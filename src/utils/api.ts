// Use relative path for API calls to leverage Vite proxy in development
// In production, use the backend URL directly
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL ||
  (import.meta.env.DEV ? '' : 'https://coffeeplug-api-b982ba0e7659.herokuapp.com')

// Log API configuration in production for debugging
if (import.meta.env.PROD) {
  console.log('API Configuration:', {
    API_BASE_URL,
    MODE: import.meta.env.MODE,
    VITE_API_BASE_URL: import.meta.env.VITE_API_BASE_URL,
    DEV: import.meta.env.DEV,
    PROD: import.meta.env.PROD
  })
}

// Get auth token from localStorage
const getAuthToken = (): string | null => {
  return localStorage.getItem('authToken')
}

// API request helper
const apiRequest = async (
  endpoint: string,
  options: RequestInit = {}
): Promise<any> => {
  const token = getAuthToken()
  const headers: Record<string, string> = {
    'Content-Type': 'application/json',
    ...(options.headers as Record<string, string> || {}),
  }

  if (token) {
    headers['Authorization'] = `Bearer ${token}`
    // Fallback headers for legacy or session-based backends
    headers['X-Session-ID'] = token
    headers['X-Auth-Token'] = token
    headers['X-CSRF-TOKEN'] = token // Some Laravel setups use this
  }

  // Only send credentials when explicitly enabled via env var.
  // This avoids breaking production when backend CORS is still using Access-Control-Allow-Origin: *
  const shouldSendCredentials =
    import.meta.env.VITE_USE_CREDENTIALS === 'true' || import.meta.env.DEV

  const fetchOptions: RequestInit = {
    ...options,
    headers,
    credentials: shouldSendCredentials ? 'include' : 'omit',
    cache: 'no-store', // Prevent caching of API responses
  }

  try {
    const fullUrl = `${API_BASE_URL}${endpoint}`
    console.log('API Request:', fullUrl, fetchOptions)

    const response = await fetch(fullUrl, fetchOptions)

    // Check if response is ok before trying to parse
    if (!response.ok) {
      // Try to get error message from response
      let errorMessage = `HTTP error! status: ${response.status}`
      try {
        const errorData = await response.json()
        errorMessage = errorData.message || errorData.error || errorMessage
      } catch (e) {
        // If response is not JSON, use status text
        errorMessage = response.statusText || errorMessage
      }
      throw new Error(errorMessage)
    }

    // Check if response has content before parsing JSON
    const contentType = response.headers.get('content-type')
    if (contentType && contentType.includes('application/json')) {
      const text = await response.text()
      if (text) {
        try {
          return JSON.parse(text)
        } catch (e) {
          console.error('Failed to parse JSON response:', text)
          throw new Error('Invalid JSON response from server')
        }
      }
      return {}
    }

    // If not JSON, return text or empty object
    const text = await response.text()
    return text || {}
  } catch (error) {
    console.error('API request error:', error)
    console.error('API_BASE_URL:', API_BASE_URL)
    console.error('Endpoint:', endpoint)
    console.error('Full URL:', `${API_BASE_URL}${endpoint}`)

    if (error instanceof TypeError) {
      if (error.message === 'Failed to fetch' || error.message.includes('fetch')) {
        // This usually means CORS blocked the request or network error
        throw new Error('Network error: Unable to connect to the server. This may be due to CORS restrictions or network issues. Please check your internet connection and try again.')
      }
      throw new Error(`Network error: ${error.message}`)
    }
    throw error
  }
}

// Stock Postings API
export const stockPostingsApi = {
  // Get stock postings with filters
  getStockPostings: async (params: {
    productType?: string
    originCountry?: string
    process?: string
    coffeeType?: string
    variety?: string
    qualityScoreLowerBound?: number
    qualityScoreUpperBound?: number
    isSpecialty?: boolean
    producedBy?: string
  } = {}): Promise<any> => {
    const queryParams = new URLSearchParams()

    Object.entries(params).forEach(([key, value]) => {
      if (value !== undefined && value !== null && value !== '') {
        queryParams.append(key, String(value))
      }
    })

    const queryString = queryParams.toString()
    const endpoint = `/api/stock-postings${queryString ? `?${queryString}` : ''}`

    return apiRequest(endpoint, { method: 'GET' })
  },

  // Get single stock posting by ID
  getStockPostingById: async (id: number): Promise<any> => {
    return apiRequest(`/api/stock-posting/${id}`, { method: 'GET' })
  },

  // Search stock postings
  searchStockPostings: async (searchQuery: string): Promise<any> => {
    return apiRequest(`/api/stock-postings-search-all?searchQuery=${encodeURIComponent(searchQuery)}`, {
      method: 'GET',
    })
  },

  // Get stock postings by supplier ID
  getStockPostingsBySupplier: async (supplierId: number): Promise<any> => {
    return apiRequest(`/api/stock-postings-by-supplier/${supplierId}`, {
      method: 'GET',
    })
  },

  // Get filter options
  getFilterOptions: async (): Promise<any> => {
    return apiRequest('/api/filter-options-stock-postings', { method: 'GET' })
  },

  // Get most popular stock postings
  getMostPopular: async (): Promise<any> => {
    return apiRequest('/api/most-popular-stock-postings', { method: 'GET' })
  },
}

// Cart API
export const cartApi = {
  // Get all cart items
  getCartItems: async (): Promise<any> => {
    return apiRequest('/api/all-cart-items', { method: 'GET' })
  },

  // Add item to cart
  addToCart: async (item: {
    stockPostingId: number
    numBags?: number
    quantity?: number // Keep for backward compatibility
    bagSize?: string
    grindType?: string
    roastType?: string
    bagImage?: string
    isRoast?: boolean
  }): Promise<any> => {
    // Send both numBags and quantity to ensure backend compatibility
    const payload = {
      ...item,
      numBags: item.numBags || item.quantity,
      quantity: item.quantity || item.numBags,
    }
    return apiRequest('/api/cart-item', {
      method: 'POST',
      body: JSON.stringify(payload),
    })
  },

  // Update cart item
  updateCartItem: async (item: {
    stockPostingId: number
    numBags?: number
    quantity?: number // Keep for backward compatibility
    bagSize?: string
    grindType?: string
    roastType?: string
    bagImage?: string
    isRoast?: boolean
  }): Promise<any> => {
    // Send both numBags and quantity to ensure backend compatibility
    const payload = {
      ...item,
      numBags: item.numBags || item.quantity,
      quantity: item.quantity || item.numBags,
    }
    return apiRequest('/api/cart-item', {
      method: 'PUT',
      body: JSON.stringify(payload),
    })
  },

  // Delete cart item
  deleteCartItem: async (stockPostingId: number): Promise<any> => {
    return apiRequest(`/api/cart-item/${stockPostingId}`, {
      method: 'DELETE',
    })
  },

  // Delete all cart items
  clearCart: async (): Promise<any> => {
    return apiRequest('/api/all-cart-items', { method: 'DELETE' })
  },

  // Get cart price breakdown
  getCartPriceBreakdown: async (): Promise<any> => {
    return apiRequest('/api/get-cart-price-breakdown', { method: 'GET' })
  },
}

// Wholesale Brands API
export const wholesaleApi = {
  // Get wholesale brands
  getWholesaleBrands: async (): Promise<any> => {
    return apiRequest('/api/whole_sale_brands', { method: 'GET' })
  },
}

// Buyer Profile API
export const buyerApi = {
  // Get buyer profile
  getBuyerProfile: async (): Promise<any> => {
    return apiRequest('/api/buyer-profile', { method: 'GET' })
  },

  // Update buyer profile
  updateBuyerProfile: async (profileData: any): Promise<any> => {
    return apiRequest('/api/buyer-profile', {
      method: 'PUT',
      body: JSON.stringify(profileData),
    })
  },
}

// Buyer Dashboard API
export const buyerDashboardApi = {
  // Get order data for dashboard (total purchases, pending orders, completed orders, most frequent orders)
  getOrderData: async (): Promise<any> => {
    return apiRequest('/api/order-data', { method: 'GET' })
  },

  // Get coffee prices (Arabica and Robusta)
  getCoffeePrices: async (): Promise<any> => {
    return apiRequest('/api/coffee-prices', { method: 'GET' })
  },

  // Get buyer monthly analytics
  getMonthlyAnalytics: async (): Promise<any> => {
    return apiRequest('/api/buyer-monthly-analytics', { method: 'GET' })
  },
}

// Buyer Orders API
export const buyerOrdersApi = {
  // Get order list
  getOrderList: async (): Promise<any> => {
    return apiRequest('/api/order-lists', { method: 'GET' })
  },

  // Get orders for DataTable (server-side)
  getOrdersDataTable: async (params: {
    draw?: number
    start?: number
    length?: number
    search?: string
  } = {}): Promise<any> => {
    const queryParams = new URLSearchParams()
    Object.entries(params).forEach(([key, value]) => {
      if (value !== undefined && value !== null && value !== '') {
        queryParams.append(key, String(value))
      }
    })
    const queryString = queryParams.toString()
    return apiRequest(`/api/orders/datatable${queryString ? `?${queryString}` : ''}`, { method: 'GET' })
  },
}

// Checkout API
export const checkoutApi = {
  /**
   * Checkout cart items
   * Matches the implementation in coffee-plug-frontend-vianexta_1.8/app/Http/Controllers/PurchaseController.php
   * 
   * @param checkoutData - Checkout data including billing and shipping addresses
   * @returns Promise with checkout response including approvalUrl, orderId, etc.
   */
  checkoutCart: async (checkoutData: {
    billingAddress: {
      addressLine1: string
      addressLine2?: string | null
      city: string
      state: string
      country: string
      zipCode: string
    }
    shippingAddress: {
      addressLine1: string
      addressLine2?: string | null
      city: string
      state: string
      country: string
      zipCode: string
    }
    paymentType?: 'PAYPAL_CHECKOUT' | 'PAYPAL_CRYPTO'
    delivery?: boolean
  }): Promise<any> => {
    // Build payload matching the PHP implementation
    const payload = {
      billingAddress: checkoutData.billingAddress,
      shippingAddress: checkoutData.shippingAddress,
      paymentType: checkoutData.paymentType || 'PAYPAL_CHECKOUT',
      ...(checkoutData.delivery !== undefined && { delivery: checkoutData.delivery }),
      // Add return and cancel URLs for PayPal redirection
      returnUrl: `${window.location.origin}/buyer?payment_success=true`,
      cancelUrl: `${window.location.origin}/checkout?payment_cancel=true`,
    } // End of payload construction

    return apiRequest('/api/checkout-cart', {
      method: 'POST',
      body: JSON.stringify(payload),
    })
  },

  /**
   * Get delivery quotes for an order
   * Matches the implementation in coffee-plug-frontend-vianexta_1.8/app/Http/Controllers/PurchaseController.php
   * 
   * @param quoteRequest - Delivery quote request data
   * @returns Promise with delivery quotes response
   */
  getDeliveryQuotes: async (quoteRequest: {
    orderId: number
    totalWeight: number
    length: number
    height: number
    insuranceAmount: number
  }): Promise<any> => {
    const payload = {
      orderId: quoteRequest.orderId,
      totalWeight: quoteRequest.totalWeight,
      length: quoteRequest.length,
      height: quoteRequest.height,
      insuranceAmount: quoteRequest.insuranceAmount,
    }

    return apiRequest('/api/delivery-quotes', {
      method: 'POST',
      body: JSON.stringify(payload),
    })
  },

  /**
   * Select a delivery quote for an order
   * Matches the implementation in coffee-plug-frontend-vianexta_1.8/app/Http/Controllers/PurchaseController.php
   * 
   * @param selectionData - Delivery quote selection data
   * @returns Promise with payment link response
   */
  selectDeliveryQuote: async (selectionData: {
    totalOrderId: number
    quoteId: string
    totalAmount: number
    paymentType?: 'PAYPAL_CHECKOUT' | 'PAYPAL_CRYPTO'
  }): Promise<any> => {
    const payload = {
      totalOrderId: selectionData.totalOrderId,
      quoteId: selectionData.quoteId,
      totalAmount: selectionData.totalAmount,
      ...(selectionData.paymentType && { paymentType: selectionData.paymentType }),
    }

    return apiRequest('/api/select-delivery-quote', {
      method: 'POST',
      body: JSON.stringify(payload),
    })
  },
}

export default {
  stockPostingsApi,
  cartApi,
  wholesaleApi,
  checkoutApi,
  buyerApi,
  buyerDashboardApi,
  buyerOrdersApi,
}


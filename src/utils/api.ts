// Use relative path for API calls to leverage Vite proxy in development
// In production, this can be configured via environment variables
const API_BASE_URL = '' // Was 'https://coffeeplug-api-b982ba0e7659.herokuapp.com'

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
  }

  // Ensure credentials are included for session cookie support
  const fetchOptions: RequestInit = {
    ...options,
    headers,
    credentials: 'include', // Important for sending/receiving cookies cross-origin
    cache: 'no-store', // Prevent caching of API responses
  }

  try {
    const response = await fetch(`${API_BASE_URL}${endpoint}`, fetchOptions)

    const data = await response.json()

    if (!response.ok) {
      throw new Error(data.message || `HTTP error! status: ${response.status}`)
    }

    return data
  } catch (error) {
    console.error('API request error:', error)
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
    // Use numBags if provided, otherwise fall back to quantity
    const payload = {
      ...item,
      numBags: item.numBags || item.quantity,
    }
    // Remove quantity if numBags is set
    if (payload.numBags) {
      delete (payload as any).quantity
    }
    return apiRequest('/api/cart-item', {
      method: 'POST',
      body: JSON.stringify(payload),
    })
  },

  // Update cart item
  updateCartItem: async (item: {
    stockPostingId: number
    quantity?: number
    bagSize?: string
    grindType?: string
    roastType?: string
    bagImage?: string
    isRoast?: boolean
  }): Promise<any> => {
    return apiRequest('/api/cart-item', {
      method: 'PUT',
      body: JSON.stringify(item),
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
}


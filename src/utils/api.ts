const API_BASE_URL = 'https://coffeeplug-api-b982ba0e7659.herokuapp.com'

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

  try {
    const response = await fetch(`${API_BASE_URL}${endpoint}`, {
      ...options,
      headers,
    })

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

export default {
  stockPostingsApi,
  cartApi,
  wholesaleApi,
}


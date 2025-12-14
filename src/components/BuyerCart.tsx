import { useState, useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import { buyerApi, cartApi } from '../utils/api'
import BuyerSidebar from './BuyerSidebar'
import BuyerTopNav from './BuyerTopNav'

function BuyerCart() {
  const navigate = useNavigate()
  const [isAuthenticated, setIsAuthenticated] = useState(false)
  const [userProfile, setUserProfile] = useState<any>(null)
  const [cartItems, setCartItems] = useState<any[]>([])
  const [loading, setLoading] = useState(true)
  const [sidebarCollapsed, setSidebarCollapsed] = useState(false)
  const [updatingItem, setUpdatingItem] = useState<number | null>(null)

  useEffect(() => {
    const checkAuth = async () => {
      try {
        const token = localStorage.getItem('authToken')
        const userStr = localStorage.getItem('user')
        const isAuth = !!token || !!userStr
        setIsAuthenticated(isAuth)

        if (isAuth) {
          if (userStr) {
            try {
              setUserProfile(JSON.parse(userStr))
            } catch (e) {
              console.error('Error parsing user profile from local storage', e)
            }
          }

          try {
            const profileResponse = await buyerApi.getBuyerProfile()
            if (profileResponse?.statusCode === 200 && profileResponse.data) {
              setUserProfile(profileResponse.data)
              localStorage.setItem('user', JSON.stringify(profileResponse.data))
            }
          } catch (apiError) {
            console.error('Error fetching fresh user profile:', apiError)
          }
        }
      } catch (authError) {
        console.error('Error in auth check:', authError)
      }
    }

    checkAuth()
  }, [])

  useEffect(() => {
    const fetchCartItems = async () => {
      if (!isAuthenticated) return

      setLoading(true)
      try {
        const response = await cartApi.getCartItems()
        if (response?.statusCode === 200 && Array.isArray(response.data)) {
          setCartItems(response.data)
        }
      } catch (err) {
        console.error('Error fetching cart items:', err)
      } finally {
        setLoading(false)
      }
    }

    fetchCartItems()
  }, [isAuthenticated])

  const handleQuantityChange = async (stockPostingId: number, newQuantity: number, cartItem: any) => {
    if (newQuantity < 1) return

    setUpdatingItem(stockPostingId)
    try {
      await cartApi.updateCartItem({
        stockPostingId,
        quantity: newQuantity,
        bagSize: cartItem.bagSize,
        grindType: cartItem.grindType,
        roastType: cartItem.roastType,
        bagImage: cartItem.bagImage,
        isRoast: cartItem.isRoast,
      })
      // Refresh cart items
      const response = await cartApi.getCartItems()
      if (response?.statusCode === 200 && Array.isArray(response.data)) {
        setCartItems(response.data)
      }
    } catch (err) {
      console.error('Error updating cart item:', err)
      alert('Failed to update quantity. Please try again.')
    } finally {
      setUpdatingItem(null)
    }
  }

  const handleRemoveItem = async (stockPostingId: number) => {
    if (!confirm('Are you sure you want to remove this item from your cart?')) return

    try {
      await cartApi.deleteCartItem(stockPostingId)
      // Refresh cart items
      const response = await cartApi.getCartItems()
      if (response?.statusCode === 200 && Array.isArray(response.data)) {
        setCartItems(response.data)
      }
    } catch (err) {
      console.error('Error removing cart item:', err)
      alert('Failed to remove item. Please try again.')
    }
  }

  const toggleSidebar = () => {
    setSidebarCollapsed(!sidebarCollapsed)
  }

  const formatMoney = (amount: number): string => {
    return new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD',
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    }).format(amount)
  }

  const calculateTotal = () => {
    return cartItems.reduce((total, item) => {
      const price = item.stockPosting?.bagPrice || 0
      const quantity = item.numBags || item.quantity || 0
      const weight = item.stockPosting?.bagWeight || 1
      return total + (price * quantity * weight)
    }, 0)
  }

  const userName = userProfile?.userFullName || userProfile?.name || userProfile?.firstName || userProfile?.businessName || 'User'

  if (loading) {
    return (
      <div className="min-h-screen bg-[#F9F7F1] flex items-center justify-center">
        <div className="text-center">
          <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-[#09543D] mx-auto mb-4"></div>
          <p className="text-[#09543D] font-medium">Loading cart...</p>
        </div>
      </div>
    )
  }

  return (
    <div className="flex min-h-screen bg-[#ECECEC]">
      {/* Sidebar */}
      <BuyerSidebar
        isCollapsed={sidebarCollapsed}
        onToggle={toggleSidebar}
        userType="Buyer"
      />

      {/* Main Content Wrapper */}
      <div
        id="content"
        className="flex-1 transition-all duration-300"
        style={{
          minHeight: '100vh',
          marginLeft: sidebarCollapsed ? '96px' : '256px',
          width: sidebarCollapsed ? 'calc(100% - 96px)' : 'calc(100% - 256px)',
        }}
      >
        {/* Top Navigation */}
        <BuyerTopNav
          userName={userName}
          onSidebarToggle={toggleSidebar}
        />

        {/* Cart Content */}
        <div className="p-4 md:p-6">
          <div className="container mx-auto">
            <div className="mb-6">
              <h1 className="text-2xl md:text-3xl font-bold mb-2" style={{ color: '#1A4D3A' }}>
                My Shopping Cart
              </h1>
              <p className="text-gray-600">
                {cartItems.length} <span>item(s)</span>
              </p>
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
              {/* Cart Items */}
              <div className="lg:col-span-2 space-y-4">
                {cartItems.length > 0 ? (
                  cartItems.map((item, index) => {
                    const stockPosting = item.stockPosting || {}
                    const itemTotal = (stockPosting.bagPrice || 0) * (item.numBags || item.quantity || 0) * (stockPosting.bagWeight || 1)
                    
                    return (
                      <div key={index} className="group bg-gradient-to-br from-white to-gray-50 rounded-xl shadow-lg hover:shadow-xl p-5 border border-gray-200 hover:border-[#07382F]/30 transition-all duration-300 hover:-translate-y-1">
                        <div className="flex flex-col md:flex-row gap-4">
                          {/* Product Image */}
                          <div className="w-full md:w-32 flex-shrink-0 relative">
                            <div className="absolute inset-0 bg-gradient-to-br from-[#07382F]/10 to-[#0d5a4a]/10 rounded-xl blur-lg group-hover:blur-xl transition-all"></div>
                            <img
                              src={stockPosting.imageUrl ? decodeURIComponent(stockPosting.imageUrl) : '/images/market_place/prod_sub.png'}
                              alt={stockPosting.description || 'Product'}
                              className="w-full h-32 object-cover rounded-xl shadow-md relative z-10 group-hover:scale-105 transition-transform duration-300"
                            />
                          </div>

                          {/* Product Details */}
                          <div className="flex-1">
                            <h6 className="font-bold text-gray-700 mb-2 uppercase">
                              {stockPosting.description || 'Product'}
                            </h6>
                            <div className="grid grid-cols-2 gap-2 text-sm text-gray-600 mb-3">
                              <div>
                                <p><strong>Species:</strong> {stockPosting.coffeeType || 'N/A'}</p>
                                {stockPosting.productType !== 'whole_sale_brand' && (
                                  <p><strong>Package:</strong> {stockPosting.bagWeight || 'N/A'} lb</p>
                                )}
                                <p><strong>Location:</strong> {stockPosting.supplierInfo?.billingCountry || 'N/A'}</p>
                              </div>
                              <div>
                                {item.isRoast ? (
                                  <>
                                    <p className="mb-1">
                                      <span className="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">
                                        <span className="w-2 h-2 bg-[#07382F] rounded-full inline-block mr-1"></span>Roasted
                                      </span>
                                    </p>
                                    <p><strong>Roast Type:</strong> {item.roastType ? item.roastType.charAt(0).toUpperCase() + item.roastType.slice(1) : 'N/A'}</p>
                                    <p><strong>Grind Type:</strong> {item.grindType ? item.grindType.charAt(0).toUpperCase() + item.grindType.slice(1) : 'N/A'}</p>
                                    <p><strong>Bag Size:</strong> {item.bagSize || 'N/A'}</p>
                                  </>
                                ) : (
                                  <p>
                                    <span className="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                      <span className="w-2 h-2 bg-[#D8501C] rounded-full inline-block mr-1"></span>{stockPosting.productType || 'Product'}
                                    </span>
                                  </p>
                                )}
                              </div>
                            </div>
                          </div>

                          {/* Price, Quantity, Actions */}
                          <div className="w-full md:w-48 flex-shrink-0">
                            <div className="text-right space-y-3">
                              <p className="font-semibold">Price: {formatMoney(stockPosting.bagPrice || 0)}</p>
                              
                              <div>
                                <label className="text-sm font-semibold mb-1 block">Quantity:</label>
                                <input
                                  type="number"
                                  min="1"
                                  value={item.numBags || item.quantity || 1}
                                  onChange={(e) => {
                                    const newQty = parseInt(e.target.value) || 1
                                    handleQuantityChange(stockPosting.id, newQty, item)
                                  }}
                                  disabled={updatingItem === stockPosting.id}
                                  className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-[#1A4D3A] focus:ring-2 focus:ring-[#1A4D3A]/20"
                                />
                              </div>

                              <p className="font-semibold">Total: {formatMoney(itemTotal)}</p>

                              <button
                                onClick={() => handleRemoveItem(stockPosting.id)}
                                className="w-full px-4 py-2.5 border-2 border-red-500 text-red-500 rounded-lg hover:bg-red-500 hover:text-white transition-all duration-200 hover:shadow-lg hover:scale-[1.02] transform text-sm font-semibold"
                              >
                                <i className="fa fa-trash mr-2"></i>Remove
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    )
                  })
                ) : (
                  <div className="bg-white rounded-lg shadow-md p-12 text-center">
                    <p className="text-gray-500 mb-4">Your cart is empty</p>
                    <button
                      onClick={() => navigate('/buyer')}
                      className="px-6 py-2 rounded text-white font-medium"
                      style={{ backgroundColor: '#1A4D3A' }}
                    >
                      Start Shopping
                    </button>
                  </div>
                )}
              </div>

              {/* Order Summary */}
              <div className="lg:col-span-1">
                <div className="bg-gradient-to-br from-white to-gray-50/50 rounded-xl shadow-xl p-6 sticky top-24 border border-gray-200">
                  <div className="mb-6 pb-4 border-b-2" style={{ borderColor: '#1A4D3A' }}>
                    <h5 className="font-bold text-xl" style={{ color: '#1A4D3A' }}>Order Summary</h5>
                  </div>
                  
                  <div className="space-y-4 mb-6">
                    <div className="flex justify-between items-center bg-gray-50/50 rounded-lg p-3">
                      <span className="font-semibold text-gray-700">Subtotal:</span>
                      <span className="font-bold text-lg" style={{ color: '#1A4D3A' }}>{formatMoney(calculateTotal())}</span>
                    </div>
                    <div className="flex justify-between items-center bg-gray-50/50 rounded-lg p-3">
                      <span className="font-semibold text-gray-700">Taxes & Shipping:</span>
                      <span className="text-gray-500 text-sm">Calculated at checkout</span>
                    </div>
                  </div>

                  <div className="border-t-2 border-gray-200 pt-4 mb-6">
                    <div className="flex justify-between items-center bg-gradient-to-r from-[#1A4D3A]/10 to-[#0d5a4a]/10 rounded-lg p-4">
                      <span className="text-xl font-bold text-gray-800">Total:</span>
                      <span className="text-2xl font-bold" style={{ color: '#1A4D3A' }}>
                        {formatMoney(calculateTotal())}
                      </span>
                    </div>
                  </div>

                  <button
                    onClick={() => navigate('/checkout')}
                    disabled={cartItems.length === 0}
                    className="w-full py-3.5 rounded-lg text-white font-semibold transition-all duration-200 hover:shadow-xl hover:scale-[1.02] transform disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100"
                    style={{ 
                      background: cartItems.length > 0 ? 'linear-gradient(135deg, #1A4D3A 0%, #0d5a4a 100%)' : '#9ca3af',
                      boxShadow: cartItems.length > 0 ? '0 4px 15px rgba(26, 77, 58, 0.2)' : 'none'
                    }}
                  >
                    Proceed to Checkout <i className="fa fa-arrow-right ml-2"></i>
                  </button>

                  <div className="text-center mt-4">
                    <button
                      onClick={() => navigate('/buyer')}
                      className="text-sm"
                      style={{ color: '#d8501c' }}
                    >
                      <i className="fa fa-plus mr-1"></i> Add More to Cart
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}

export default BuyerCart



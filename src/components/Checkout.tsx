import { useState, useEffect } from 'react'
import { Link, useNavigate } from 'react-router-dom'
import { cartApi, checkoutApi, buyerApi } from '../utils/api'
import buyLogo from '../../assets/buy-logo.svg'

function Checkout() {
  const navigate = useNavigate()
  const [cartItems, setCartItems] = useState<any[]>([])
  const [priceBreakdown, setPriceBreakdown] = useState<any>(null)
  const [profileData, setProfileData] = useState<any>(null)
  const [loading, setLoading] = useState(true)
  const [submitting, setSubmitting] = useState(false)
  const [error, setError] = useState<string | null>(null)

  // Form state
  const [billingAddress, setBillingAddress] = useState({
    addressLine1: '',
    addressLine2: '',
    city: '',
    state: '',
    country: 'United States',
    zipCode: '',
  })

  const [shippingAddress, setShippingAddress] = useState({
    addressLine1: '',
    addressLine2: '',
    city: '',
    state: '',
    country: 'United States',
    zipCode: '',
  })

  const [paymentType, setPaymentType] = useState<'PAYPAL_CHECKOUT' | 'PAYPAL_CRYPTO'>('PAYPAL_CHECKOUT')
  const [delivery, setDelivery] = useState(false)
  const [sameAsBilling, setSameAsBilling] = useState(false)

  // US States list
  const usStates = [
    'Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado',
    'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho',
    'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana',
    'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota',
    'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada',
    'New Hampshire', 'New Jersey', 'New Mexico', 'New York',
    'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon',
    'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota',
    'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington',
    'West Virginia', 'Wisconsin', 'Wyoming'
  ]

  // Fetch cart items, price breakdown, and profile on mount
  useEffect(() => {
    const fetchCheckoutData = async () => {
      try {
        setLoading(true)
        setError(null)

        // Check authentication first (matching old implementation)
        // We don't force redirect here anymore to allow for session-based or guest checkout flows
        // If the API returns 401, we'll handle it in the API error catch block


        // Fetch cart items
        try {
          const cartResponse = await cartApi.getCartItems()
          console.log('Cart response:', cartResponse)

          if (cartResponse?.statusCode === 200) {
            const items = Array.isArray(cartResponse.data) ? cartResponse.data : []
            setCartItems(items)

            // If cart is empty, redirect to buyer wizard (matching old implementation)
            if (items.length === 0) {
              console.log('Cart is empty, redirecting to buyer wizard')
              navigate('/buyer')
              return
            }
          } else {
            // If API call fails or returns error, show error but don't redirect
            console.error('Failed to fetch cart items:', cartResponse)
            setError('Failed to load cart items. Please try again.')
            setLoading(false)
            return
          }
        } catch (cartError: any) {
          console.error('Error fetching cart:', cartError)

          // Check for auth error
          if (cartError.message && (cartError.message.includes('401') || cartError.message.toLowerCase().includes('unauthenticated'))) {
            console.log('Cart fetch failed with 401, redirecting to sign in')
            navigate('/signin')
            return
          }

          setError('Failed to load cart items. Please try again.')
          setLoading(false)
          return
        }

        // Fetch price breakdown
        try {
          const priceResponse = await cartApi.getCartPriceBreakdown()
          if (priceResponse?.statusCode === 200) {
            setPriceBreakdown(priceResponse.data)
          }
        } catch (priceError) {
          console.log('Price breakdown not available:', priceError)
        }

        // Fetch buyer profile
        try {
          const profileResponse = await buyerApi.getBuyerProfile()
          if (profileResponse?.statusCode === 200 && profileResponse.data) {
            setProfileData(profileResponse.data)

            // Prepopulate billing address from profile
            const profile = profileResponse.data
            if (profile.shippingAddressLine1) {
              setBillingAddress({
                addressLine1: profile.shippingAddressLine1 || '',
                addressLine2: profile.shippingAddressLine2 || '',
                city: profile.shippingCity || '',
                state: profile.shippingState || '',
                country: profile.shippingCountry || 'United States',
                zipCode: profile.shippingZipCode || '',
              })

              // Also set shipping address
              setShippingAddress({
                addressLine1: profile.shippingAddressLine1 || '',
                addressLine2: profile.shippingAddressLine2 || '',
                city: profile.shippingCity || '',
                state: profile.shippingState || '',
                country: profile.shippingCountry || 'United States',
                zipCode: profile.shippingZipCode || '',
              })
            }
          }
        } catch (profileError) {
          console.log('Profile not available, using empty form')
        }
      } catch (error) {
        console.error('Error fetching checkout data:', error)
        setError('Failed to load checkout data. Please try again.')
      } finally {
        setLoading(false)
      }
    }

    fetchCheckoutData()

  }, [navigate])

  // Handle payment cancellation
  useEffect(() => {
    const params = new URLSearchParams(window.location.search)
    if (params.get('payment_cancel') === 'true' || params.get('cancel') === 'true') {
      setError('Payment was cancelled. You can try again or choose a different payment method.')
      window.history.replaceState({}, '', window.location.pathname)
    }
  }, [])


  // Handle same as billing checkbox
  useEffect(() => {
    if (sameAsBilling) {
      setShippingAddress({ ...billingAddress })
    }
  }, [sameAsBilling, billingAddress])

  // Handle form submission
  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()
    setSubmitting(true)
    setError(null)

    try {
      // Validate required fields
      if (!billingAddress.addressLine1 || !billingAddress.city ||
        !billingAddress.state || !billingAddress.country || !billingAddress.zipCode) {
        setError('Please fill in all required billing address fields')
        setSubmitting(false)
        return
      }

      if (!shippingAddress.addressLine1 || !shippingAddress.city ||
        !shippingAddress.state || !shippingAddress.country || !shippingAddress.zipCode) {
        setError('Please fill in all required shipping address fields')
        setSubmitting(false)
        return
      }

      // Submit checkout
      const response = await checkoutApi.checkoutCart({
        billingAddress,
        shippingAddress,
        paymentType,
        delivery,
      })

      if (response?.statusCode === 200 || response?.success === true) {
        const data = response.data || response

        // If delivery is selected, redirect to delivery quotes page
        if (delivery && data.orderId) {
          // Store order data for delivery quotes page
          sessionStorage.setItem('checkout_order_id', data.orderId.toString())
          sessionStorage.setItem('checkout_total_amount', (data.totalPrice || 0).toString())
          sessionStorage.setItem('checkout_payment_type', paymentType)
          sessionStorage.setItem('checkout_insurance_amount',
            (data.insuranceAmount || (data.totalPrice || 0) * 0.01).toString())

          // Navigate to delivery quotes (we'll need to create this component later)
          // For now, redirect to order history or show success
          navigate('/buyer?delivery=true')
          return
        }

        // If approvalUrl exists, redirect to PayPal
        if (data.approvalUrl) {
          window.location.href = data.approvalUrl
          return
        }

        // Otherwise, clear cart and redirect to order history
        await cartApi.clearCart()
        navigate('/buyer?success=true')
      } else {
        setError(response?.message || 'Checkout failed. Please try again.')
      }
    } catch (error: any) {
      console.error('Checkout error:', error)
      setError(error?.message || 'An error occurred during checkout. Please try again.')
    } finally {
      setSubmitting(false)
    }
  }

  if (loading) {
    return (
      <div className="min-h-screen bg-[#F9F7F1] flex items-center justify-center">
        <div className="text-center">
          <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-[#D8501C] mx-auto"></div>
          <p className="mt-4 text-gray-600">Loading checkout...</p>
        </div>
      </div>
    )
  }

  return (
    <div className="min-h-screen bg-[#F9F7F1]">
      <header className="fixed top-0 left-0 right-0 z-50 bg-gradient-to-r from-[#1A4D3A] to-[#2d7a5f] py-4 shadow-md">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
          <Link to="/buyer">
            <img src={buyLogo} alt="ViaNexta" className="h-8 brightness-0 invert" />
          </Link>
          <Link
            to="/buyer"
            className="bg-white/20 backdrop-blur-sm text-white px-6 py-2 rounded-full font-medium hover:bg-white/30 transition-all border border-white/30"
          >
            Marketplace
          </Link>
        </div>
      </header>

      {/* Checkout Header */}
      <div className="bg-gradient-to-r from-[#1A4D3A] to-[#2d7a5f] text-white py-8 pt-28">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <h1
            className="text-4xl font-medium text-center mb-2"
            style={{
              fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
              letterSpacing: '1px'
            }}
          >
            Complete Your Order
          </h1>
          <p className="text-center text-lg opacity-90">Review your items and provide billing information to complete your purchase</p>
        </div>
      </div>

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
          {/* Left Column - Order Summary */}
          <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 className="text-2xl font-semibold text-[#1A4D3A] mb-6 pb-3 border-b border-gray-200">
              Order Summary
            </h2>

            {cartItems.length > 0 ? (
              <>
                <div className="max-h-[500px] overflow-y-auto pr-2 space-y-4 mb-6">
                  {cartItems.map((item: any, index: number) => {
                    const stockPosting = item.stockPosting || {}

                    // Calculate price matching BuyerWizard logic
                    let itemPrice = 0
                    let packageDisplay = stockPosting.bagWeight ? `${stockPosting.bagWeight} lb` : ''

                    if (stockPosting.productType === 'whole_sale_brand') {
                      let basePrice = parseFloat(stockPosting.bagPrice || 0)
                      // Apply size multipliers matching BuyerWizard
                      if (item.bagSize === '16oz Retail Bag') basePrice *= 1.2
                      else if (item.bagSize === '5lb Bag') basePrice *= 3.5

                      itemPrice = basePrice * (item.numBags || 0)
                      packageDisplay = item.bagSize || 'Case'
                    } else {
                      // Regular products (Roasted)
                      let weight = 0.75 // Default 12oz

                      // Determination weight from bagSize
                      if (item.bagSize === '5lb') weight = 5
                      else if (item.bagSize === '12oz') weight = 0.75
                      else if (item.bagSize === '10oz') weight = 0.625
                      else if (item.bagSize === 'kcup') weight = 0.75
                      else if (item.bagSize?.startsWith('frac_pack')) {
                        weight = item.bagSize.includes('3oz') ? 0.1875 : 0.25
                      } else if (stockPosting.bagWeight) {
                        weight = parseFloat(stockPosting.bagWeight)
                      }

                      // Determine spot price
                      let spotPrice = parseFloat(stockPosting.spotPrice || stockPosting.spot_price || stockPosting.price || 0)
                      if (spotPrice === 0 && stockPosting.bagPrice && stockPosting.bagWeight) {
                        const bp = parseFloat(stockPosting.bagPrice)
                        const bw = parseFloat(stockPosting.bagWeight)
                        spotPrice = bw > 0 ? bp / bw : 0
                      }

                      itemPrice = spotPrice * weight * (item.numBags || 0)

                      if (item.bagSize) {
                        packageDisplay = item.bagSize.replace('frac_pack_', '') + (item.bagSize.includes('frac') ? ' Frac Pack' : '')
                      } else {
                        packageDisplay = `${weight} lb`
                      }
                    }

                    return (
                      <div key={index} className="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div className="flex items-center gap-4">
                          <img
                            src={stockPosting.imageUrl ? decodeURIComponent(stockPosting.imageUrl) : '/images/market_place/prod_sub.png'}
                            alt="Product"
                            className="w-20 h-20 object-cover rounded-lg border-2 border-gray-200"
                          />
                          <div className="flex-1">
                            <h6 className="font-semibold text-[#1A4D3A] mb-1">
                              ORDER #{stockPosting.id}
                            </h6>
                            <p className="text-sm text-gray-600 mb-1">
                              <strong>Product:</strong>{' '}
                              {stockPosting.supplierInfo?.firstName === 'Win' || stockPosting.productType === 'whole_sale_brand'
                                ? (stockPosting.description || '').toUpperCase()
                                : stockPosting.name || stockPosting.description || 'Product Name'}
                            </p>
                            <p className="text-sm text-gray-600 mb-1">
                              <strong>Quantity:</strong> {item.numBags} bags
                            </p>
                            <p className="text-sm text-gray-600">
                              <strong>Package:</strong> {packageDisplay}
                            </p>
                          </div>
                          <div className="text-right">
                            <div className="text-lg font-bold text-[#1A4D3A]">
                              ${itemPrice.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                            </div>
                          </div>
                        </div>
                      </div>
                    )
                  })}
                </div>

                {/* Price Summary */}
                <div className="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-5 border border-gray-200">
                  <div className="space-y-3">
                    <div className="flex justify-between items-center pb-2 border-b border-gray-300">
                      <span className="font-medium">Sub Total:</span>
                      <span className="font-semibold">
                        ${cartItems.reduce((sum, item) => {
                          const stockPosting = item.stockPosting || {}
                          let itemPrice = 0

                          if (stockPosting.productType === 'whole_sale_brand') {
                            let basePrice = parseFloat(stockPosting.bagPrice || 0)
                            if (item.bagSize === '16oz Retail Bag') basePrice *= 1.2
                            else if (item.bagSize === '5lb Bag') basePrice *= 3.5
                            itemPrice = basePrice * (item.numBags || 0)
                          } else {
                            let weight = 0.75
                            if (item.bagSize === '5lb') weight = 5
                            else if (item.bagSize === '12oz') weight = 0.75
                            else if (item.bagSize === '10oz') weight = 0.625
                            else if (item.bagSize === 'kcup') weight = 0.75
                            else if (item.bagSize?.startsWith('frac_pack')) {
                              weight = item.bagSize.includes('3oz') ? 0.1875 : 0.25
                            } else if (stockPosting.bagWeight) {
                              weight = parseFloat(stockPosting.bagWeight)
                            }

                            let spotPrice = parseFloat(stockPosting.spotPrice || stockPosting.spot_price || stockPosting.price || '0')
                            if (spotPrice === 0 && stockPosting.bagPrice && stockPosting.bagWeight) {
                              const bPrice = parseFloat(stockPosting.bagPrice) || 0
                              const bWeight = parseFloat(stockPosting.bagWeight) || 1
                              spotPrice = bWeight > 0 ? bPrice / bWeight : 0
                            }
                            itemPrice = (item.numBags || 0) * (spotPrice * weight)
                          }
                          return sum + itemPrice
                        }, 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                      </span>
                    </div>
                    <div className="flex justify-between items-center pb-2 border-b border-gray-300">
                      <span className="font-medium">Coordination Fee:</span>
                      <span className="font-semibold">
                        ${(priceBreakdown?.cooperativeFee || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                      </span>
                    </div>
                    <div className="flex justify-between items-center pt-2">
                      <span className="text-xl font-bold">TOTAL:</span>
                      <span className="text-xl font-bold text-[#1A4D3A]">
                        ${(cartItems.reduce((sum, item) => {
                          const stockPosting = item.stockPosting || {}
                          let itemPrice = 0

                          if (stockPosting.productType === 'whole_sale_brand') {
                            let basePrice = parseFloat(stockPosting.bagPrice || 0)
                            if (item.bagSize === '16oz Retail Bag') basePrice *= 1.2
                            else if (item.bagSize === '5lb Bag') basePrice *= 3.5
                            itemPrice = basePrice * (item.numBags || 0)
                          } else {
                            let weight = 0.75
                            if (item.bagSize === '5lb') weight = 5
                            else if (item.bagSize === '12oz') weight = 0.75
                            else if (item.bagSize === '10oz') weight = 0.625
                            else if (item.bagSize === 'kcup') weight = 0.75
                            else if (item.bagSize?.startsWith('frac_pack')) {
                              weight = item.bagSize.includes('3oz') ? 0.1875 : 0.25
                            } else if (stockPosting.bagWeight) {
                              weight = parseFloat(stockPosting.bagWeight)
                            }

                            let spotPrice = parseFloat(stockPosting.spotPrice || stockPosting.spot_price || stockPosting.price || '0')
                            if (spotPrice === 0 && stockPosting.bagPrice && stockPosting.bagWeight) {
                              const bPrice = parseFloat(stockPosting.bagPrice) || 0
                              const bWeight = parseFloat(stockPosting.bagWeight) || 1
                              spotPrice = bWeight > 0 ? bPrice / bWeight : 0
                            }
                            itemPrice = (item.numBags || 0) * (spotPrice * weight)
                          }
                          return sum + itemPrice
                        }, 0) + (priceBreakdown?.cooperativeFee || 0)).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                      </span>
                    </div>
                  </div>
                </div>
              </>
            ) : (
              <div className="text-center py-12">
                <h5 className="text-xl font-semibold mb-2">No items in cart</h5>
                <p className="text-gray-600 mb-4">Please add items to your cart before proceeding to checkout.</p>
                <button
                  onClick={() => navigate('/buyer')}
                  className="bg-[#D8501C] text-white px-6 py-2 rounded-lg hover:bg-[#b73d1a] transition-colors"
                >
                  Continue Shopping
                </button>
              </div>
            )}
          </div>

          {/* Right Column - Payment & Shipping */}
          <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 className="text-2xl font-semibold text-[#1A4D3A] mb-6 pb-3 border-b border-gray-200">
              Payment & Shipping
            </h2>

            {cartItems.length > 0 ? (
              <form onSubmit={handleSubmit} className="space-y-6">
                {error && (
                  <div className="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    {error}
                  </div>
                )}

                {/* Billing Details */}
                <div>
                  <h5 className="text-lg font-bold mb-4">Billing Details</h5>

                  {profileData?.shippingAddressLine1 ? (
                    <div className="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg mb-4">
                      <i className="fas fa-info-circle mr-2"></i>
                      Your billing information has been prepopulated with your shipping address. You can modify these details if needed.
                    </div>
                  ) : (
                    <div className="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-lg mb-4">
                      <i className="fas fa-exclamation-triangle mr-2"></i>
                      Please fill in your billing information. You can save your address in your profile for future checkouts.
                    </div>
                  )}

                  <div className="space-y-4">
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">
                        Address Line 1 *
                      </label>
                      <input
                        type="text"
                        required
                        value={billingAddress.addressLine1}
                        onChange={(e) => setBillingAddress({ ...billingAddress, addressLine1: e.target.value })}
                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1A4D3A] focus:border-transparent"
                        placeholder="Enter your street address"
                      />
                    </div>

                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">
                        Address Line 2
                      </label>
                      <input
                        type="text"
                        value={billingAddress.addressLine2}
                        onChange={(e) => setBillingAddress({ ...billingAddress, addressLine2: e.target.value })}
                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1A4D3A] focus:border-transparent"
                        placeholder="Apartment, suite, etc. (optional)"
                      />
                    </div>

                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">
                        Country *
                      </label>
                      <select
                        required
                        value={billingAddress.country}
                        onChange={(e) => setBillingAddress({ ...billingAddress, country: e.target.value })}
                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1A4D3A] focus:border-transparent"
                      >
                        <option value="United States">United States</option>
                      </select>
                    </div>

                    <div className="grid grid-cols-2 gap-4">
                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-1">
                          State/Province *
                        </label>
                        <select
                          required
                          value={billingAddress.state}
                          onChange={(e) => setBillingAddress({ ...billingAddress, state: e.target.value })}
                          className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1A4D3A] focus:border-transparent"
                        >
                          <option value="">Select State</option>
                          {usStates.map((state) => (
                            <option key={state} value={state}>
                              {state}
                            </option>
                          ))}
                        </select>
                      </div>

                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-1">
                          City *
                        </label>
                        <input
                          type="text"
                          required
                          value={billingAddress.city}
                          onChange={(e) => setBillingAddress({ ...billingAddress, city: e.target.value })}
                          className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1A4D3A] focus:border-transparent"
                          placeholder="Enter city"
                        />
                      </div>
                    </div>

                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">
                        ZIP Code *
                      </label>
                      <input
                        type="text"
                        required
                        value={billingAddress.zipCode}
                        onChange={(e) => setBillingAddress({ ...billingAddress, zipCode: e.target.value })}
                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1A4D3A] focus:border-transparent"
                        placeholder="Enter ZIP code"
                      />
                    </div>
                  </div>
                </div>

                {/* Shipping Details */}
                <div>
                  <div className="flex items-center mb-4">
                    <input
                      type="checkbox"
                      id="sameAsBilling"
                      checked={sameAsBilling}
                      onChange={(e) => setSameAsBilling(e.target.checked)}
                      className="mr-2"
                    />
                    <label htmlFor="sameAsBilling" className="text-sm font-medium text-gray-700">
                      Shipping address same as billing address
                    </label>
                  </div>

                  <h5 className="text-lg font-bold mb-4">Shipping Details</h5>

                  <div className="space-y-4">
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">
                        Address Line 1 *
                      </label>
                      <input
                        type="text"
                        required
                        value={shippingAddress.addressLine1}
                        onChange={(e) => setShippingAddress({ ...shippingAddress, addressLine1: e.target.value })}
                        disabled={sameAsBilling}
                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1A4D3A] focus:border-transparent disabled:bg-gray-100"
                        placeholder="Enter your street address"
                      />
                    </div>

                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">
                        Address Line 2
                      </label>
                      <input
                        type="text"
                        value={shippingAddress.addressLine2}
                        onChange={(e) => setShippingAddress({ ...shippingAddress, addressLine2: e.target.value })}
                        disabled={sameAsBilling}
                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1A4D3A] focus:border-transparent disabled:bg-gray-100"
                        placeholder="Apartment, suite, etc. (optional)"
                      />
                    </div>

                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">
                        Country *
                      </label>
                      <select
                        required
                        value={shippingAddress.country}
                        onChange={(e) => setShippingAddress({ ...shippingAddress, country: e.target.value })}
                        disabled={sameAsBilling}
                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1A4D3A] focus:border-transparent disabled:bg-gray-100"
                      >
                        <option value="United States">United States</option>
                      </select>
                    </div>

                    <div className="grid grid-cols-2 gap-4">
                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-1">
                          State/Province *
                        </label>
                        <select
                          required
                          value={shippingAddress.state}
                          onChange={(e) => setShippingAddress({ ...shippingAddress, state: e.target.value })}
                          disabled={sameAsBilling}
                          className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1A4D3A] focus:border-transparent disabled:bg-gray-100"
                        >
                          <option value="">Select State</option>
                          {usStates.map((state) => (
                            <option key={state} value={state}>
                              {state}
                            </option>
                          ))}
                        </select>
                      </div>

                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-1">
                          City *
                        </label>
                        <input
                          type="text"
                          required
                          value={shippingAddress.city}
                          onChange={(e) => setShippingAddress({ ...shippingAddress, city: e.target.value })}
                          disabled={sameAsBilling}
                          className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1A4D3A] focus:border-transparent disabled:bg-gray-100"
                          placeholder="Enter city"
                        />
                      </div>
                    </div>

                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">
                        ZIP Code *
                      </label>
                      <input
                        type="text"
                        required
                        value={shippingAddress.zipCode}
                        onChange={(e) => setShippingAddress({ ...shippingAddress, zipCode: e.target.value })}
                        disabled={sameAsBilling}
                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1A4D3A] focus:border-transparent disabled:bg-gray-100"
                        placeholder="Enter ZIP code"
                      />
                    </div>
                  </div>
                </div>

                {/* Payment Type */}
                <div>
                  <h5 className="text-lg font-bold mb-4">Payment Method</h5>
                  <div className="space-y-2">
                    <label className="flex items-center">
                      <input
                        type="radio"
                        name="paymentType"
                        value="PAYPAL_CHECKOUT"
                        checked={paymentType === 'PAYPAL_CHECKOUT'}
                        onChange={(e) => setPaymentType(e.target.value as 'PAYPAL_CHECKOUT')}
                        className="mr-2"
                      />
                      <span>PayPal Checkout</span>
                    </label>
                    <label className="flex items-center">
                      <input
                        type="radio"
                        name="paymentType"
                        value="PAYPAL_CRYPTO"
                        checked={paymentType === 'PAYPAL_CRYPTO'}
                        onChange={(e) => setPaymentType(e.target.value as 'PAYPAL_CRYPTO')}
                        className="mr-2"
                      />
                      <span>PayPal Crypto</span>
                    </label>
                  </div>
                </div>

                {/* Delivery Option */}
                <div>
                  <label className="flex items-center">
                    <input
                      type="checkbox"
                      checked={delivery}
                      onChange={(e) => setDelivery(e.target.checked)}
                      className="mr-2"
                    />
                    <span className="text-sm font-medium text-gray-700">
                      I need delivery service
                    </span>
                  </label>
                </div>

                {/* Submit Button */}
                <button
                  type="submit"
                  disabled={submitting}
                  className="w-full bg-[#1A4D3A] text-white py-4 rounded-lg font-bold text-lg hover:bg-[#0d261d] transition-colors disabled:opacity-70 disabled:cursor-not-allowed"
                >
                  {submitting ? 'Processing...' : 'Complete Order'}
                </button>
              </form>
            ) : (
              <div className="text-center py-12">
                <p className="text-gray-600 mb-4">Your cart is empty.</p>
                <button
                  onClick={() => navigate('/buyer')}
                  className="bg-[#D8501C] text-white px-6 py-2 rounded-lg hover:bg-[#b73d1a] transition-colors"
                >
                  Continue Shopping
                </button>
              </div>
            )}
          </div>
        </div>
      </div>
    </div>
  )
}

export default Checkout


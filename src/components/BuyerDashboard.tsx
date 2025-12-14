import { useState, useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import { buyerApi, buyerDashboardApi } from '../utils/api'
import BuyerSidebar from './BuyerSidebar'
import BuyerTopNav from './BuyerTopNav'
import { BarChart, Bar, XAxis, YAxis, CartesianGrid, Tooltip, ResponsiveContainer } from 'recharts'

interface DashboardStats {
  totalPurchases: {
    quantity: number
    totalPrice: number
  }
  pendingOrders: {
    quantity: number
    totalPrice: number
  }
  completedOrders: {
    quantity: number
    totalPrice: number
  }
  mostFrequentOrders: Array<{
    productName: string
    quantity: number
    totalPrice: number
    stockPostingId: number
  }>
}

interface CoffeePrices {
  arabica: {
    dateTime: string
    currency: string
    price: number
    unit: string
    closingPrice: number | null
  }
  robusta: {
    dateTime: string
    currency: string
    price: number
    unit: string
    closingPrice: number | null
  }
}

interface AnalyticsData {
  date: string
  totalPrice: number
}

interface UserProfile {
  userFullName?: string
  name?: string
  firstName?: string
  businessName?: string
  email?: string
  phoneNumber?: string
  jobTitle?: string
  elevation?: string
  foundedYear?: string
  imageUrl?: string
  shippingAddressLine1?: string
  shippingAddressLine2?: string
  shippingCountry?: string
  shippingState?: string
  shippingCity?: string
  shippingZipCode?: string
  billingAddressLine1?: string
  billingAddressLine2?: string
  billingCountry?: string
  billingState?: string
  billingCity?: string
  billingZipCode?: string
}

function BuyerDashboard() {
  const navigate = useNavigate()
  const [isAuthenticated, setIsAuthenticated] = useState(false)
  const [userProfile, setUserProfile] = useState<UserProfile | null>(null)
  const [dashboardStats, setDashboardStats] = useState<DashboardStats | null>(null)
  const [coffeePrices, setCoffeePrices] = useState<CoffeePrices | null>(null)
  const [analyticsData, setAnalyticsData] = useState<AnalyticsData[]>([])
  const [loading, setLoading] = useState(true)
  const [error, setError] = useState<string | null>(null)
  const [sidebarCollapsed, setSidebarCollapsed] = useState(false)

  // Check authentication and fetch user profile
  useEffect(() => {
    const checkAuth = async () => {
      try {
        const token = localStorage.getItem('authToken')
        const userStr = localStorage.getItem('user')
        const isAuth = !!token || !!userStr
        setIsAuthenticated(isAuth)

        if (isAuth) {
          // Try to get user profile from localStorage first for immediate display
          if (userStr) {
            try {
              setUserProfile(JSON.parse(userStr))
            } catch (e) {
              console.error('Error parsing user profile from local storage', e)
            }
          }

          // Fetch fresh profile data from API
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

  // Fetch order data
  const fetchOrderData = async () => {
    try {
      const orderData = await buyerDashboardApi.getOrderData()
      if (orderData && orderData.data) {
        setDashboardStats(orderData.data)
      }
    } catch (err) {
      console.error('Error fetching order data:', err)
      throw err
    }
  }

  // Fetch coffee prices
  const fetchCoffeePrices = async () => {
    try {
      const pricesData = await buyerDashboardApi.getCoffeePrices()
      if (pricesData && pricesData.data) {
        setCoffeePrices(pricesData.data)
      }
    } catch (priceError) {
      console.warn('Failed to fetch coffee prices:', priceError)
    }
  }

  // Fetch analytics data
  const fetchAnalytics = async () => {
    try {
      const analytics = await buyerDashboardApi.getMonthlyAnalytics()
      if (analytics && analytics.data && Array.isArray(analytics.data)) {
        setAnalyticsData(analytics.data)
      }
    } catch (analyticsError) {
      console.warn('Failed to fetch analytics:', analyticsError)
    }
  }

  // Fetch dashboard data
  useEffect(() => {
    const fetchDashboardData = async () => {
      if (!isAuthenticated) return

      setLoading(true)
      setError(null)

      try {
        await fetchOrderData()
        await fetchCoffeePrices()
        await fetchAnalytics()
      } catch (err) {
        console.error('Error fetching dashboard data:', err)
        const errorMessage = err instanceof Error ? err.message : 'Failed to load dashboard data'
        setError(errorMessage)
      } finally {
        setLoading(false)
      }
    }

    fetchDashboardData()
  }, [isAuthenticated])

  const formatMoney = (amount: number): string => {
    return new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD',
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    }).format(amount)
  }

  const formatDate = (dateString: string): string => {
    if (!dateString) return ''
    const date = new Date(dateString)
    return date.toLocaleTimeString('en-US', {
      hour: '2-digit',
      minute: '2-digit',
    })
  }

  const isWeekend = (): boolean => {
    const today = new Date()
    return today.getDay() === 0 || today.getDay() === 6
  }

  const toggleSidebar = () => {
    setSidebarCollapsed(!sidebarCollapsed)
  }

  const userName = userProfile?.userFullName || userProfile?.name || userProfile?.firstName || userProfile?.businessName || 'User'

  if (loading) {
    return (
      <div className="min-h-screen bg-[#F9F7F1] flex items-center justify-center">
        <div className="text-center">
          <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-[#09543D] mx-auto mb-4"></div>
          <p className="text-[#09543D] font-medium">Loading dashboard...</p>
        </div>
      </div>
    )
  }

  if (error) {
    return (
      <div className="min-h-screen bg-[#F9F7F1] flex items-center justify-center">
        <div className="text-center">
          <p className="text-red-600 font-medium mb-4">{error}</p>
          <button
            onClick={() => navigate('/buyer')}
            className="bg-[#09543D] text-white px-6 py-2 rounded-full hover:bg-[#0d6b4f] transition-colors"
          >
            Go to Buyer Wizard
          </button>
        </div>
      </div>
    )
  }

  return (
    <div className="flex min-h-screen bg-[#F9F7F1]">
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

        {/* Dashboard Content */}
        <div className="p-4 md:p-6">
          <div className="container-xxl mx-auto">
            <div className="mb-8 pb-4 border-b-2" style={{ borderColor: '#07382F' }}>
              <h1 className="text-3xl md:text-4xl font-bold mb-2 bg-gradient-to-r from-[#07382F] to-[#0d5a4a] bg-clip-text text-transparent">
                {userName}'s Dashboard
              </h1>
              <p className="text-gray-600">Welcome back! Here's an overview of your account activity.</p>
            </div>

            {/* Stats Cards */}
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-6">
              {/* Total Purchases */}
              <div className="group bg-gradient-to-br from-white via-white to-gray-50 rounded-xl shadow-lg hover:shadow-2xl p-6 h-full border border-gray-100 transition-all duration-300 hover:-translate-y-1">
                <div className="flex flex-col md:flex-row gap-4 h-full">
                  <div className="w-full md:w-1/3 flex items-center justify-center pt-2">
                    <div className="relative">
                      <div className="absolute inset-0 bg-gradient-to-br from-[#07382F]/10 to-[#0d5a4a]/10 rounded-full blur-xl animate-pulse"></div>
                      <img
                        src="/images/seller/dash_two.svg"
                        alt="Purchases"
                        className="w-24 h-24 md:w-full md:h-auto object-contain relative z-10 transform group-hover:scale-110 transition-transform duration-300"
                        onError={(e) => {
                          // Fallback icon
                          e.currentTarget.outerHTML = '<div class="w-24 h-24 bg-[#07382F]/10 rounded-lg flex items-center justify-center"><svg class="w-12 h-12 text-[#07382F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4l1-12z" /></svg></div>'
                        }}
                      />
                    </div>
                  </div>
                  <div className="flex-1 flex flex-col justify-between">
                    <div>
                      <p className="text-gray-500 text-xs uppercase tracking-wide mb-3 font-semibold">Total number of purchases</p>
                      <h5 className="text-center text-lg font-bold text-[#07382F] mb-2">
                        <span className="font-normal text-sm text-gray-600">Quantity:</span> {dashboardStats?.totalPurchases?.quantity || 0} <span className="text-sm font-normal">bags</span>
                      </h5>
                      <h5 className="text-center text-lg font-bold text-[#07382F]">
                        <span className="font-normal text-sm text-gray-600">Amount:</span> {formatMoney(dashboardStats?.totalPurchases?.totalPrice || 0)}
                      </h5>
                    </div>
                    <button
                      onClick={() => navigate('/buyer')}
                      className="w-full mt-4 py-2.5 rounded-lg text-white font-semibold transition-all duration-200 hover:shadow-lg hover:scale-[1.02] transform"
                      style={{ 
                        background: 'linear-gradient(135deg, #07382F 0%, #0d5a4a 100%)',
                        boxShadow: '0 4px 15px rgba(7, 56, 47, 0.2)'
                      }}
                    >
                      View details <i className="fa fa-arrow-right ml-2"></i>
                    </button>
                  </div>
                </div>
              </div>

              {/* Pending Orders */}
              <div className="group bg-gradient-to-br from-white via-amber-50/30 to-white rounded-xl shadow-lg hover:shadow-2xl p-6 h-full border border-amber-100 transition-all duration-300 hover:-translate-y-1">
                <div className="flex flex-col md:flex-row gap-4 h-full">
                  <div className="w-full md:w-1/3 flex items-center justify-center pt-2">
                    <div className="relative">
                      <div className="absolute inset-0 bg-gradient-to-br from-amber-400/20 to-orange-400/20 rounded-full blur-xl animate-pulse"></div>
                      <img
                        src="/images/seller/dash_one.svg"
                        alt="Pending"
                        className="w-24 h-24 md:w-full md:h-auto object-contain relative z-10 transform group-hover:scale-110 transition-transform duration-300"
                        onError={(e) => {
                          e.currentTarget.outerHTML = '<div class="w-24 h-24 bg-yellow-100 rounded-lg flex items-center justify-center"><svg class="w-12 h-12 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>'
                        }}
                      />
                    </div>
                  </div>
                  <div className="flex-1 flex flex-col justify-between">
                    <div>
                      <p className="text-gray-500 text-xs uppercase tracking-wide mb-3 font-semibold">Total pending orders</p>
                      <h5 className="text-center text-lg font-bold text-[#07382F] mb-2">
                        <span className="font-normal text-sm text-gray-600">Quantity:</span> {dashboardStats?.pendingOrders?.quantity || 0} <span className="text-sm font-normal">bags</span>
                      </h5>
                      <h5 className="text-center text-lg font-bold text-[#07382F]">
                        <span className="font-normal text-sm text-gray-600">Amount:</span> {formatMoney(dashboardStats?.pendingOrders?.totalPrice || 0)}
                      </h5>
                    </div>
                    <button
                      onClick={() => navigate('/buyer')}
                      className="w-full mt-4 py-2.5 rounded-lg text-white font-semibold transition-all duration-200 hover:shadow-lg hover:scale-[1.02] transform"
                      style={{ 
                        background: 'linear-gradient(135deg, #07382F 0%, #0d5a4a 100%)',
                        boxShadow: '0 4px 15px rgba(7, 56, 47, 0.2)'
                      }}
                    >
                      View details <i className="fa fa-arrow-right ml-2"></i>
                    </button>
                  </div>
                </div>
              </div>

              {/* Completed Orders */}
              <div className="group bg-gradient-to-br from-white via-green-50/30 to-white rounded-xl shadow-lg hover:shadow-2xl p-6 h-full border border-green-100 transition-all duration-300 hover:-translate-y-1">
                <div className="flex flex-col md:flex-row gap-4 h-full">
                  <div className="w-full md:w-1/3 flex items-center justify-center pt-2">
                    <div className="relative">
                      <div className="absolute inset-0 bg-gradient-to-br from-green-400/20 to-emerald-400/20 rounded-full blur-xl animate-pulse"></div>
                      <img
                        src="/images/seller/dash_three.svg"
                        alt="Completed"
                        className="w-24 h-24 md:w-full md:h-auto object-contain relative z-10 transform group-hover:scale-110 transition-transform duration-300"
                        onError={(e) => {
                          e.currentTarget.outerHTML = '<div class="w-24 h-24 bg-green-100 rounded-lg flex items-center justify-center"><svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>'
                        }}
                      />
                    </div>
                  </div>
                  <div className="flex-1 flex flex-col justify-between">
                    <div>
                      <p className="text-gray-500 text-xs uppercase tracking-wide mb-3 font-semibold">Total of completed orders</p>
                      <h5 className="text-center text-lg font-bold text-[#07382F] mb-2">
                        <span className="font-normal text-sm text-gray-600">Quantity:</span> {dashboardStats?.completedOrders?.quantity || 0} <span className="text-sm font-normal">bags</span>
                      </h5>
                      <h5 className="text-center text-lg font-bold text-[#07382F]">
                        <span className="font-normal text-sm text-gray-600">Amount:</span> {formatMoney(dashboardStats?.completedOrders?.totalPrice || 0)}
                      </h5>
                    </div>
                    <button
                      onClick={() => navigate('/buyer')}
                      className="w-full mt-4 py-2.5 rounded-lg text-white font-semibold transition-all duration-200 hover:shadow-lg hover:scale-[1.02] transform"
                      style={{ 
                        background: 'linear-gradient(135deg, #07382F 0%, #0d5a4a 100%)',
                        boxShadow: '0 4px 15px rgba(7, 56, 47, 0.2)'
                      }}
                    >
                      View details <i className="fa fa-arrow-right ml-2"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            {/* Most Frequent Orders - Card View */}
            {dashboardStats?.mostFrequentOrders && dashboardStats.mostFrequentOrders.length > 0 && (
              <div className="mb-6">
                <div className="bg-gradient-to-br from-white to-gray-50/50 rounded-xl shadow-lg p-4 md:p-6 mb-4 border border-gray-200">
                  <div className="p-4 border-b-2 mb-6 rounded-t-lg bg-gradient-to-r from-[#07382F] to-[#0d5a4a]" style={{ borderColor: '#07382F' }}>
                    <h4 className="text-center text-xl font-bold text-white">
                      List of most often bought coffee type
                    </h4>
                  </div>
                  
                  {/* Card Grid View */}
                  <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mb-6">
                    {dashboardStats.mostFrequentOrders.map((order, index) => (
                      <div
                        key={index}
                        className="group bg-gradient-to-br from-white via-white to-gray-50 rounded-xl shadow-md hover:shadow-xl p-5 border border-gray-200 hover:border-[#07382F]/30 transition-all duration-300 hover:-translate-y-1"
                      >
                        <div className="flex items-center justify-between mb-4">
                          <span className="text-3xl font-bold bg-gradient-to-br from-[#07382F] to-[#0d5a4a] bg-clip-text text-transparent">#{index + 1}</span>
                          <div className="w-14 h-14 bg-gradient-to-br from-[#07382F]/10 to-[#0d5a4a]/10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg className="w-7 h-7 text-[#07382F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                          </div>
                        </div>
                        <h5 className="text-lg font-bold text-[#07382F] mb-3 line-clamp-2 min-h-[3.5rem]">
                          {order.productName}
                        </h5>
                        <div className="space-y-2 mb-5 bg-gray-50/50 rounded-lg p-3">
                          <p className="text-sm text-gray-700">
                            <span className="font-semibold text-gray-600">Quantity:</span> <span className="font-bold text-[#07382F]">{order.quantity}</span> <span className="text-gray-500">bags</span>
                          </p>
                          <p className="text-sm text-gray-700">
                            <span className="font-semibold text-gray-600">Amount:</span> <span className="font-bold text-[#07382F]">{formatMoney(order.totalPrice)}</span>
                          </p>
                        </div>
                        <button
                          onClick={() => navigate(`/buyer?productId=${order.stockPostingId}`)}
                          className="w-full py-2.5 rounded-lg text-white text-sm font-semibold transition-all duration-200 hover:shadow-lg hover:scale-[1.02] transform"
                          style={{ 
                            background: 'linear-gradient(135deg, #07382F 0%, #0d5a4a 100%)',
                            boxShadow: '0 4px 15px rgba(7, 56, 47, 0.2)'
                          }}
                        >
                          View Details <i className="fa fa-arrow-right ml-2"></i>
                        </button>
                      </div>
                    ))}
                  </div>

                  {/* Table View (Alternative) */}
                  <div className="overflow-x-auto rounded-lg border border-gray-200">
                    <table className="w-full table-auto">
                      <thead>
                        <tr className="bg-gradient-to-r from-[#07382F] to-[#0d5a4a]">
                          <th className="text-left py-4 px-6 text-sm font-bold text-white w-1/12">#</th>
                          <th className="text-left py-4 px-6 text-sm font-bold text-white w-4/12">Name</th>
                          <th className="text-left py-4 px-6 text-sm font-bold text-white w-2/12">Quantity</th>
                          <th className="text-left py-4 px-6 text-sm font-bold text-white w-2/12">Amount</th>
                          <th className="text-left py-4 px-6 text-sm font-bold text-white w-3/12">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        {dashboardStats.mostFrequentOrders.map((order, index) => (
                          <tr key={index} className="border-b border-gray-100 hover:bg-gradient-to-r hover:from-gray-50 hover:to-white transition-colors duration-200">
                            <td className="py-4 px-6 text-gray-700 font-bold">{index + 1}</td>
                            <td className="py-4 px-6 text-gray-700 font-semibold">{order.productName}</td>
                            <td className="py-4 px-6 text-gray-700">{order.quantity} <span className="text-gray-500 text-sm">bags</span></td>
                            <td className="py-4 px-6 text-gray-700 font-bold" style={{ color: '#07382F' }}>{formatMoney(order.totalPrice)}</td>
                            <td className="py-4 px-6">
                              <button
                                onClick={() => navigate(`/buyer?productId=${order.stockPostingId}`)}
                                className="px-4 py-2 rounded-lg text-white text-sm font-semibold transition-all duration-200 hover:shadow-md hover:scale-105 transform"
                                style={{ 
                                  background: 'linear-gradient(135deg, #07382F 0%, #0d5a4a 100%)',
                                  boxShadow: '0 2px 8px rgba(7, 56, 47, 0.2)'
                                }}
                              >
                                View <i className="fa fa-arrow-right ml-1"></i>
                              </button>
                            </td>
                          </tr>
                        ))}
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            )}

            {/* Coffee Prices */}
            {coffeePrices && (
              <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6">
                {/* Arabica Current Price */}
                <div className="bg-white rounded-lg shadow-md p-4 border border-gray-200">
                  <div className="flex items-center gap-3">
                    <div className="w-12 h-12 flex items-center justify-center flex-shrink-0">
                      <img
                        src="/images/seller/dash_four.svg"
                        alt="Price"
                        className="w-full h-full object-contain"
                        onError={(e) => {
                          e.currentTarget.style.display = 'none'
                        }}
                      />
                    </div>
                    <div className="flex-1 min-w-0">
                      <p className="text-gray-600 text-xs mb-1">
                        Arabica Price {isWeekend() ? 'Last Friday' : 'Today'} ({formatDate(coffeePrices.arabica.dateTime)})
                      </p>
                      <h6 className="text-sm font-semibold text-[#07382F]">
                        <span>{coffeePrices.arabica.currency} {coffeePrices.arabica.price.toFixed(2)}</span> ({coffeePrices.arabica.unit})
                      </h6>
                    </div>
                  </div>
                </div>

                {/* Robusta Current Price */}
                <div className="bg-white rounded-lg shadow-md p-4 border border-gray-200">
                  <div className="flex items-center gap-3">
                    <div className="w-12 h-12 flex items-center justify-center flex-shrink-0">
                      <img
                        src="/images/seller/dash_four.svg"
                        alt="Price"
                        className="w-full h-full object-contain"
                        onError={(e) => {
                          e.currentTarget.style.display = 'none'
                        }}
                      />
                    </div>
                    <div className="flex-1 min-w-0">
                      <p className="text-gray-600 text-xs mb-1">
                        Robusta Price {isWeekend() ? 'Last Friday' : 'Today'} ({formatDate(coffeePrices.robusta.dateTime)})
                      </p>
                      <h6 className="text-sm font-semibold text-[#07382F]">
                        <span>{coffeePrices.robusta.currency} {coffeePrices.robusta.price.toFixed(2)}</span> ({coffeePrices.robusta.unit})
                      </h6>
                    </div>
                  </div>
                </div>

                {/* Arabica Previous Day */}
                {coffeePrices.arabica.closingPrice !== null && (
                  <div className="bg-white rounded-lg shadow-md p-4 border border-gray-200">
                    <div className="flex items-center gap-3">
                      <div className="w-12 h-12 flex items-center justify-center flex-shrink-0">
                        <img
                          src="/images/seller/dash_four.svg"
                          alt="Price"
                          className="w-full h-full object-contain"
                          onError={(e) => {
                            e.currentTarget.style.display = 'none'
                          }}
                        />
                      </div>
                      <div className="flex-1 min-w-0">
                        <p className="text-gray-600 text-xs mb-1">Arabica Previous day's prices</p>
                        <h6 className="text-sm font-semibold text-[#07382F]">
                          <span>{coffeePrices.arabica.currency} {coffeePrices.arabica.closingPrice.toFixed(2)}</span> ({coffeePrices.arabica.unit})
                        </h6>
                      </div>
                    </div>
                  </div>
                )}

                {/* Robusta Previous Day */}
                {coffeePrices.robusta.closingPrice !== null && (
                  <div className="bg-white rounded-lg shadow-md p-4 border border-gray-200">
                    <div className="flex items-center gap-3">
                      <div className="w-12 h-12 flex items-center justify-center flex-shrink-0">
                        <img
                          src="/images/seller/dash_four.svg"
                          alt="Price"
                          className="w-full h-full object-contain"
                          onError={(e) => {
                            e.currentTarget.style.display = 'none'
                          }}
                        />
                      </div>
                      <div className="flex-1 min-w-0">
                        <p className="text-gray-600 text-xs mb-1">Robusta Previous day's prices</p>
                        <h6 className="text-sm font-semibold text-[#07382F]">
                          <span>{coffeePrices.robusta.currency} {coffeePrices.robusta.closingPrice.toFixed(2)}</span> ({coffeePrices.robusta.unit})
                        </h6>
                      </div>
                    </div>
                  </div>
                )}
              </div>
            )}

            {/* Analytics Chart */}
            <div className="bg-white rounded-lg shadow-md p-4 md:p-6 border border-gray-200" style={{ borderColor: '#07382F' }}>
              <div className="p-3 border-b-2 mb-4" style={{ borderColor: '#07382F' }}>
                <h4 className="text-center text-xl font-bold text-[#07382F]">Analytics of monthly orders</h4>
              </div>
              <div className="p-3">
                {analyticsData.length > 0 ? (
                  <ResponsiveContainer width="100%" height={500}>
                    <BarChart data={analyticsData}>
                      <CartesianGrid strokeDasharray="3 3" />
                      <XAxis
                        dataKey="date"
                        angle={-90}
                        textAnchor="end"
                        height={100}
                      />
                      <YAxis
                        tickFormatter={(value) => `$${value}`}
                      />
                      <Tooltip
                        formatter={(value: number) => `$${value.toFixed(2)}`}
                      />
                      <Bar
                        dataKey="totalPrice"
                        fill="#ffcab6"
                        radius={[5, 5, 0, 0]}
                      />
                    </BarChart>
                  </ResponsiveContainer>
                ) : (
                  <div className="h-96 flex items-center justify-center text-gray-400">
                    <p>No analytics data available</p>
                  </div>
                )}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}

export default BuyerDashboard

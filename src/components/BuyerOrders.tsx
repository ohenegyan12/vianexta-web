import { useState, useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import { buyerApi, buyerDashboardApi, buyerOrdersApi } from '../utils/api'
import BuyerSidebar from './BuyerSidebar'
import BuyerTopNav from './BuyerTopNav'

function BuyerOrders() {
  const navigate = useNavigate()
  const [isAuthenticated, setIsAuthenticated] = useState(false)
  const [userProfile, setUserProfile] = useState<any>(null)
  const [dashboardStats, setDashboardStats] = useState<any>(null)
  const [orders, setOrders] = useState<any[]>([])
  const [loading, setLoading] = useState(true)
  const [sidebarCollapsed, setSidebarCollapsed] = useState(false)

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
    const fetchData = async () => {
      if (!isAuthenticated) return

      setLoading(true)
      try {
        // Fetch dashboard stats
        const orderData = await buyerDashboardApi.getOrderData()
        if (orderData && orderData.data) {
          setDashboardStats(orderData.data)
        }

        // Fetch orders
        const ordersResponse = await buyerOrdersApi.getOrderList()
        if (ordersResponse && ordersResponse.data) {
          setOrders(Array.isArray(ordersResponse.data) ? ordersResponse.data : [])
        }
      } catch (err) {
        console.error('Error fetching orders data:', err)
      } finally {
        setLoading(false)
      }
    }

    fetchData()
  }, [isAuthenticated])

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

  const formatDate = (dateString: string): string => {
    if (!dateString) return 'N/A'
    const date = new Date(dateString)
    return date.toLocaleDateString('en-US', {
      year: 'numeric',
      month: 'short',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit',
    })
  }

  const userName = userProfile?.userFullName || userProfile?.name || userProfile?.firstName || userProfile?.businessName || 'User'

  if (loading) {
    return (
      <div className="min-h-screen bg-[#F9F7F1] flex items-center justify-center">
        <div className="text-center">
          <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-[#09543D] mx-auto mb-4"></div>
          <p className="text-[#09543D] font-medium">Loading orders...</p>
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

        {/* Orders Content */}
        <div className="p-4 md:p-6">
          <div className="container-xxl mx-auto">
            {/* Stats Cards */}
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-6">
              {/* Total Purchases */}
              <div className="bg-white rounded-lg shadow-md p-4 h-full border border-gray-200">
                <div className="flex flex-col md:flex-row gap-4 h-full">
                  <div className="w-full md:w-1/3 flex items-center justify-center pt-2">
                    <img
                      src="/images/seller/dash_two.svg"
                      alt="Purchases"
                      className="w-24 h-24 md:w-full md:h-auto object-contain"
                      onError={(e) => {
                        e.currentTarget.style.display = 'none'
                      }}
                    />
                  </div>
                  <div className="flex-1 flex flex-col justify-between">
                    <div>
                      <p className="text-gray-600 text-sm mb-3">Total number of purchases</p>
                      <h5 className="text-center text-base font-semibold text-[#07382F] mb-1">
                        <span className="font-normal">Quantity:</span> {dashboardStats?.totalPurchases?.quantity || 0} bags
                      </h5>
                      <h5 className="text-center text-base font-semibold text-[#07382F]">
                        <span className="font-normal">Amount:</span> {formatMoney(dashboardStats?.totalPurchases?.totalPrice || 0)}
                      </h5>
                    </div>
                  </div>
                </div>
              </div>

              {/* Pending Orders */}
              <div className="bg-white rounded-lg shadow-md p-4 h-full border border-gray-200">
                <div className="flex flex-col md:flex-row gap-4 h-full">
                  <div className="w-full md:w-1/3 flex items-center justify-center pt-2">
                    <img
                      src="/images/seller/dash_one.svg"
                      alt="Pending"
                      className="w-24 h-24 md:w-full md:h-auto object-contain"
                      onError={(e) => {
                        e.currentTarget.style.display = 'none'
                      }}
                    />
                  </div>
                  <div className="flex-1 flex flex-col justify-between">
                    <div>
                      <p className="text-gray-600 text-sm mb-3">Total pending orders</p>
                      <h5 className="text-center text-base font-semibold text-[#07382F] mb-1">
                        <span className="font-normal">Quantity:</span> {dashboardStats?.pendingOrders?.quantity || 0} bags
                      </h5>
                      <h5 className="text-center text-base font-semibold text-[#07382F]">
                        <span className="font-normal">Amount:</span> {formatMoney(dashboardStats?.pendingOrders?.totalPrice || 0)}
                      </h5>
                    </div>
                  </div>
                </div>
              </div>

              {/* Completed Orders */}
              <div className="bg-white rounded-lg shadow-md p-4 h-full border border-gray-200">
                <div className="flex flex-col md:flex-row gap-4 h-full">
                  <div className="w-full md:w-1/3 flex items-center justify-center pt-2">
                    <img
                      src="/images/seller/dash_three.svg"
                      alt="Completed"
                      className="w-24 h-24 md:w-full md:h-auto object-contain"
                      onError={(e) => {
                        e.currentTarget.style.display = 'none'
                      }}
                    />
                  </div>
                  <div className="flex-1 flex flex-col justify-between">
                    <div>
                      <p className="text-gray-600 text-sm mb-3">Total completed Orders</p>
                      <h5 className="text-center text-base font-semibold text-[#07382F] mb-1">
                        <span className="font-normal">Quantity:</span> {dashboardStats?.completedOrders?.quantity || 0} bags
                      </h5>
                      <h5 className="text-center text-base font-semibold text-[#07382F]">
                        <span className="font-normal">Amount:</span> {formatMoney(dashboardStats?.completedOrders?.totalPrice || 0)}
                      </h5>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {/* Order History Table */}
            <div className="bg-gradient-to-br from-white to-gray-50/50 rounded-xl shadow-lg p-4 md:p-6 border border-gray-200">
              <div className="mb-6 pb-4 border-b-2" style={{ borderColor: '#1A4D3A' }}>
                <h3 className="text-2xl font-bold mb-2" style={{ color: '#1A4D3A' }}>Order History</h3>
                <p className="text-gray-600">All your orders with detailed information</p>
              </div>
              <div className="overflow-x-auto rounded-lg border border-gray-200">
                {orders.length > 0 ? (
                  <table className="w-full table-auto">
                    <thead>
                      <tr className="bg-gradient-to-r from-[#1A4D3A] to-[#0d5a4a]">
                        <th className="text-left py-4 px-6 text-sm font-bold text-white">Order ID</th>
                        <th className="text-left py-4 px-6 text-sm font-bold text-white">Status</th>
                        <th className="text-left py-4 px-6 text-sm font-bold text-white">Payment Status</th>
                        <th className="text-left py-4 px-6 text-sm font-bold text-white">Date Purchased</th>
                        <th className="text-left py-4 px-6 text-sm font-bold text-white">Quantity</th>
                        <th className="text-left py-4 px-6 text-sm font-bold text-white">Amount</th>
                        <th className="text-left py-4 px-6 text-sm font-bold text-white">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      {orders.map((order, index) => (
                        <tr key={index} className="border-b border-gray-100 hover:bg-gradient-to-r hover:from-gray-50 hover:to-white transition-colors duration-200">
                          <td className="py-4 px-6 text-gray-700 font-bold">#{order.id || order.orderId || index + 1}</td>
                          <td className="py-4 px-6">
                            <span className={`px-3 py-1.5 rounded-full text-xs font-semibold shadow-sm ${
                              order.status === 'Processing' || order.status === 'Pending'
                                ? 'bg-yellow-100 text-yellow-800 border border-yellow-200'
                                : 'bg-green-100 text-green-800 border border-green-200'
                            }`}>
                              {order.status || 'N/A'}
                            </span>
                          </td>
                          <td className="py-4 px-6">
                            <span className={`px-3 py-1.5 rounded-full text-xs font-semibold shadow-sm ${
                              order.paymentStatus === 'PENDING'
                                ? 'bg-yellow-100 text-yellow-800 border border-yellow-200'
                                : order.paymentStatus === 'COMPLETED'
                                ? 'bg-green-100 text-green-800 border border-green-200'
                                : 'bg-gray-100 text-gray-800 border border-gray-200'
                            }`}>
                              {order.paymentStatus || 'N/A'}
                            </span>
                          </td>
                          <td className="py-4 px-6 text-gray-700">{formatDate(order.createdDate || order.datePurchased)}</td>
                          <td className="py-4 px-6 text-gray-700 font-semibold">{order.numBags || order.quantity || 0} <span className="text-gray-500 text-sm">bags</span></td>
                          <td className="py-4 px-6 text-gray-700 font-bold" style={{ color: '#1A4D3A' }}>
                            {formatMoney(order.totalPrice || order.amount || 0)}
                          </td>
                          <td className="py-4 px-6">
                            <button
                              onClick={() => navigate(`/buyer/orders/${order.id || order.orderId}`)}
                              className="px-4 py-2 rounded-lg text-white text-sm font-semibold transition-all duration-200 hover:shadow-md hover:scale-105 transform"
                              style={{ 
                                background: 'linear-gradient(135deg, #1A4D3A 0%, #0d5a4a 100%)',
                                boxShadow: '0 2px 8px rgba(26, 77, 58, 0.2)'
                              }}
                            >
                              View Details <i className="fa fa-arrow-right ml-1"></i>
                            </button>
                          </td>
                        </tr>
                      ))}
                    </tbody>
                  </table>
                ) : (
                  <div className="text-center py-16 bg-gradient-to-br from-gray-50 to-white rounded-lg">
                    <div className="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                      <i className="fa fa-inbox text-3xl text-gray-400"></i>
                    </div>
                    <p className="text-gray-500 mb-6 text-lg">No orders found</p>
                    <button
                      onClick={() => navigate('/buyer')}
                      className="px-8 py-3 rounded-lg text-white font-semibold transition-all duration-200 hover:shadow-lg hover:scale-105 transform"
                      style={{ 
                        background: 'linear-gradient(135deg, #1A4D3A 0%, #0d5a4a 100%)',
                        boxShadow: '0 4px 15px rgba(26, 77, 58, 0.2)'
                      }}
                    >
                      Start Shopping <i className="fa fa-arrow-right ml-2"></i>
                    </button>
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

export default BuyerOrders


import { useState, useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import { buyerApi } from '../utils/api'
import BuyerSidebar from './BuyerSidebar'
import BuyerTopNav from './BuyerTopNav'

function BuyerAccount() {
  const navigate = useNavigate()
  const [isAuthenticated, setIsAuthenticated] = useState(false)
  const [userProfile, setUserProfile] = useState<any>(null)
  const [loading, setLoading] = useState(true)
  const [sidebarCollapsed, setSidebarCollapsed] = useState(false)
  const [showEditModal, setShowEditModal] = useState(false)
  const [showPasswordModal, setShowPasswordModal] = useState(false)

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
      } finally {
        setLoading(false)
      }
    }

    checkAuth()
  }, [])

  const toggleSidebar = () => {
    setSidebarCollapsed(!sidebarCollapsed)
  }

  const userName = userProfile?.userFullName || userProfile?.name || userProfile?.firstName || userProfile?.businessName || 'User'
  const userEmail = userProfile?.email || ''

  if (loading) {
    return (
      <div className="min-h-screen bg-[#F9F7F1] flex items-center justify-center">
        <div className="text-center">
          <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-[#09543D] mx-auto mb-4"></div>
          <p className="text-[#09543D] font-medium">Loading account...</p>
        </div>
      </div>
    )
  }

  return (
    <div className="flex min-h-screen bg-[#F5F5F5]">
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

        {/* Account Content */}
        <div className="p-4 md:p-6">
          <div className="container-xxl mx-auto">
            <h1 className="text-lg md:text-xl font-medium mb-4" style={{ color: '#656565', marginTop: '10px' }}>
              ACCOUNT INFORMATION
            </h1>
            <hr className="mb-4" />

            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
              {/* Profile Card */}
              <div className="md:col-span-1">
                <div className="bg-gradient-to-br from-white to-gray-50 rounded-xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transition-all duration-300">
                  {userProfile?.imageUrl ? (
                    <div className="relative mb-6">
                      <div className="absolute inset-0 bg-gradient-to-br from-[#07382F]/20 to-[#0d5a4a]/20 rounded-xl blur-xl"></div>
                      <img
                        src={decodeURIComponent(userProfile.imageUrl)}
                        alt="Profile"
                        className="w-full h-64 object-cover rounded-xl mb-4 relative z-10 shadow-lg"
                      />
                    </div>
                  ) : (
                    <div className="w-full h-64 bg-gradient-to-br from-[#07382F] via-[#0d5a4a] to-[#07382F] rounded-xl flex items-center justify-center mb-6 shadow-lg relative overflow-hidden">
                      <div className="absolute inset-0 bg-gradient-to-br from-transparent via-white/10 to-transparent animate-pulse"></div>
                      <svg className="w-24 h-24 text-white relative z-10" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                      </svg>
                    </div>
                  )}
                  <div className="space-y-3">
                    <h1 className="text-2xl font-bold bg-gradient-to-r from-[#07382F] to-[#0d5a4a] bg-clip-text text-transparent">{userName}</h1>
                    <div className="space-y-2 bg-gray-50/50 rounded-lg p-4">
                      <p className="text-sm text-gray-700"><span className="font-semibold text-gray-600">Email:</span> {userEmail}</p>
                      <p className="text-sm text-gray-700"><span className="font-semibold text-gray-600">Number:</span> {userProfile?.phoneNumber || 'N/A'}</p>
                      <p className="text-sm text-gray-700"><span className="font-semibold text-gray-600">Job Title:</span> {userProfile?.jobTitle || 'N/A'}</p>
                      <p className="text-sm text-gray-700"><span className="font-semibold text-gray-600">Elevation:</span> {userProfile?.elevation || 'N/A'}</p>
                      <p className="text-sm text-gray-700"><span className="font-semibold text-gray-600">Founded Year:</span> {userProfile?.foundedYear || 'N/A'}</p>
                    </div>
                    <div className="flex flex-col gap-3 mt-6">
                      <button
                        onClick={() => setShowEditModal(true)}
                        className="w-full py-3 rounded-lg text-white font-semibold transition-all duration-200 hover:shadow-lg hover:scale-[1.02] transform"
                        style={{ 
                          background: 'linear-gradient(135deg, #07382F 0%, #0d5a4a 100%)',
                          boxShadow: '0 4px 15px rgba(7, 56, 47, 0.2)'
                        }}
                      >
                        <i className="fa fa-edit mr-2"></i>Edit Profile
                      </button>
                      <button
                        onClick={() => setShowPasswordModal(true)}
                        className="w-full py-3 rounded-lg border-2 font-semibold transition-all duration-200 hover:shadow-lg hover:scale-[1.02] transform"
                        style={{ borderColor: '#07382F', color: '#07382F' }}
                      >
                        <i className="fa fa-key mr-2"></i>Reset Password
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              {/* Addresses Card */}
              <div className="md:col-span-2">
                <div className="bg-gradient-to-br from-white to-gray-50/50 rounded-xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transition-all duration-300">
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {/* Shipping Address */}
                    <div className="border-r-2 border-gray-200 pr-6">
                      <div className="mb-5 pb-3 border-b-2" style={{ borderColor: '#07382F' }}>
                        <h2 className="text-lg font-bold uppercase tracking-wide" style={{ color: '#07382F' }}>
                          <i className="fa fa-truck mr-2"></i>DEFAULT SHIPPING ADDRESS
                        </h2>
                      </div>
                      <div className="space-y-3">
                        <div className="bg-gradient-to-r from-gray-50 to-white rounded-lg p-4 border border-gray-200 hover:border-[#07382F]/30 transition-colors">
                          <p className="text-sm font-medium mb-0 text-gray-700">
                            <span className="font-semibold text-gray-600">Address Line 1:</span> {userProfile?.shippingAddressLine1 || 'N/A'}
                          </p>
                        </div>
                        <div className="bg-gradient-to-r from-gray-50 to-white rounded-lg p-4 border border-gray-200 hover:border-[#07382F]/30 transition-colors">
                          <p className="text-sm font-medium mb-0 text-gray-700">
                            <span className="font-semibold text-gray-600">Address Line 2:</span> {userProfile?.shippingAddressLine2 || 'N/A'}
                          </p>
                        </div>
                        <div className="bg-gradient-to-r from-gray-50 to-white rounded-lg p-4 border border-gray-200 hover:border-[#07382F]/30 transition-colors">
                          <p className="text-sm font-medium mb-0 text-gray-700">
                            <span className="font-semibold text-gray-600">Country:</span> {userProfile?.shippingCountry || 'N/A'}
                          </p>
                        </div>
                        <div className="bg-gradient-to-r from-gray-50 to-white rounded-lg p-4 border border-gray-200 hover:border-[#07382F]/30 transition-colors">
                          <p className="text-sm font-medium mb-0 text-gray-700">
                            <span className="font-semibold text-gray-600">State:</span> {userProfile?.shippingState || 'N/A'}
                          </p>
                        </div>
                        <div className="bg-gradient-to-r from-gray-50 to-white rounded-lg p-4 border border-gray-200 hover:border-[#07382F]/30 transition-colors">
                          <p className="text-sm font-medium mb-0 text-gray-700">
                            <span className="font-semibold text-gray-600">City:</span> {userProfile?.shippingCity || 'N/A'}
                          </p>
                        </div>
                        <div className="bg-gradient-to-r from-gray-50 to-white rounded-lg p-4 border border-gray-200 hover:border-[#07382F]/30 transition-colors">
                          <p className="text-sm font-medium mb-0 text-gray-700">
                            <span className="font-semibold text-gray-600">Zip Code:</span> {userProfile?.shippingZipCode || 'N/A'}
                          </p>
                        </div>
                      </div>
                    </div>

                    {/* Billing Address */}
                    <div className="pl-0 md:pl-6">
                      <div className="mb-5 pb-3 border-b-2" style={{ borderColor: '#07382F' }}>
                        <h2 className="text-lg font-bold uppercase tracking-wide" style={{ color: '#07382F' }}>
                          <i className="fa fa-credit-card mr-2"></i>DEFAULT BILLING ADDRESS
                        </h2>
                      </div>
                      <div className="space-y-3">
                        <div className="bg-gradient-to-r from-gray-50 to-white rounded-lg p-4 border border-gray-200 hover:border-[#07382F]/30 transition-colors">
                          <p className="text-sm font-medium mb-0 text-gray-700">
                            <span className="font-semibold text-gray-600">Address Line 1:</span> {userProfile?.billingAddressLine1 || 'N/A'}
                          </p>
                        </div>
                        <div className="bg-gradient-to-r from-gray-50 to-white rounded-lg p-4 border border-gray-200 hover:border-[#07382F]/30 transition-colors">
                          <p className="text-sm font-medium mb-0 text-gray-700">
                            <span className="font-semibold text-gray-600">Address Line 2:</span> {userProfile?.billingAddressLine2 || 'N/A'}
                          </p>
                        </div>
                        <div className="bg-gradient-to-r from-gray-50 to-white rounded-lg p-4 border border-gray-200 hover:border-[#07382F]/30 transition-colors">
                          <p className="text-sm font-medium mb-0 text-gray-700">
                            <span className="font-semibold text-gray-600">Country:</span> {userProfile?.billingCountry || 'N/A'}
                          </p>
                        </div>
                        <div className="bg-gradient-to-r from-gray-50 to-white rounded-lg p-4 border border-gray-200 hover:border-[#07382F]/30 transition-colors">
                          <p className="text-sm font-medium mb-0 text-gray-700">
                            <span className="font-semibold text-gray-600">State:</span> {userProfile?.billingState || 'N/A'}
                          </p>
                        </div>
                        <div className="bg-gradient-to-r from-gray-50 to-white rounded-lg p-4 border border-gray-200 hover:border-[#07382F]/30 transition-colors">
                          <p className="text-sm font-medium mb-0 text-gray-700">
                            <span className="font-semibold text-gray-600">City:</span> {userProfile?.billingCity || 'N/A'}
                          </p>
                        </div>
                        <div className="bg-gradient-to-r from-gray-50 to-white rounded-lg p-4 border border-gray-200 hover:border-[#07382F]/30 transition-colors">
                          <p className="text-sm font-medium mb-0 text-gray-700">
                            <span className="font-semibold text-gray-600">Zip Code:</span> {userProfile?.billingZipCode || 'N/A'}
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                {/* Newsletter Section */}
                <div className="mt-6 rounded-xl shadow-xl p-8 relative overflow-hidden group" style={{
                  backgroundImage: 'url(/images/profiles/profile_coffee_background.png)',
                  backgroundRepeat: 'no-repeat',
                  backgroundSize: 'cover',
                }}>
                  <div className="absolute inset-0 bg-gradient-to-br from-[#07382F]/90 via-[#0d5a4a]/80 to-[#07382F]/90 group-hover:from-[#07382F]/95 group-hover:via-[#0d5a4a]/85 group-hover:to-[#07382F]/95 transition-all duration-300"></div>
                  <div className="relative z-10">
                    <div className="text-3xl font-bold text-white mb-2 drop-shadow-lg">ViaNexta</div>
                    <div className="text-3xl font-bold mb-3 drop-shadow-lg" style={{ color: '#D8501C' }}>NEWSLETTER</div>
                    <p className="text-white mb-6 text-lg drop-shadow-md">
                      Keep up to date with all the latest news, updates and promotions from us
                    </p>
                    <form
                      onSubmit={(e) => {
                        e.preventDefault()
                        // Handle newsletter subscription
                        alert('Newsletter subscription feature coming soon!')
                      }}
                      className="flex flex-col gap-3"
                    >
                      <input
                        type="email"
                        value={userEmail}
                        readOnly
                        className="mb-3 form-control text-center font-bold bg-white/95 rounded-lg px-4 py-3 border-2 border-white/50 shadow-lg focus:outline-none focus:ring-2 focus:ring-white/50"
                        placeholder="Email address"
                      />
                      <button
                        type="submit"
                        className="bg-gradient-to-r from-[#D8501C] to-[#c0451a] text-white px-8 py-3 rounded-lg font-semibold hover:shadow-xl hover:scale-[1.02] transition-all duration-200 transform"
                      >
                        Subscribe now <i className="fa fa-angle-double-right ml-2"></i>
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Edit Profile Modal */}
      {showEditModal && (
        <div className="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
          <div className="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div className="p-6 border-b border-gray-200">
              <div className="flex justify-between items-center">
                <h3 className="text-xl font-bold" style={{ color: '#07382F' }}>Edit Profile</h3>
                <button
                  onClick={() => setShowEditModal(false)}
                  className="text-gray-500 hover:text-gray-700"
                >
                  <i className="fa fa-times text-xl"></i>
                </button>
              </div>
            </div>
            <div className="p-6">
              <p className="text-gray-600 mb-4">Profile editing functionality will be implemented here.</p>
              <button
                onClick={() => setShowEditModal(false)}
                className="px-6 py-2 rounded text-white font-medium"
                style={{ backgroundColor: '#07382F' }}
              >
                Close
              </button>
            </div>
          </div>
        </div>
      )}

      {/* Reset Password Modal */}
      {showPasswordModal && (
        <div className="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
          <div className="bg-white rounded-lg max-w-md w-full">
            <div className="p-6 border-b border-gray-200">
              <div className="flex justify-between items-center">
                <h3 className="text-xl font-bold" style={{ color: '#07382F' }}>Reset Password</h3>
                <button
                  onClick={() => setShowPasswordModal(false)}
                  className="text-gray-500 hover:text-gray-700"
                >
                  <i className="fa fa-times text-xl"></i>
                </button>
              </div>
            </div>
            <div className="p-6">
              <p className="text-gray-600 mb-4">Password reset functionality will be implemented here.</p>
              <button
                onClick={() => setShowPasswordModal(false)}
                className="px-6 py-2 rounded text-white font-medium"
                style={{ backgroundColor: '#07382F' }}
              >
                Close
              </button>
            </div>
          </div>
        </div>
      )}
    </div>
  )
}

export default BuyerAccount


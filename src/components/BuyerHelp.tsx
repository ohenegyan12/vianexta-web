import { useState, useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import { buyerApi } from '../utils/api'
import BuyerSidebar from './BuyerSidebar'
import BuyerTopNav from './BuyerTopNav'

function BuyerHelp() {
  const navigate = useNavigate()
  const [isAuthenticated, setIsAuthenticated] = useState(false)
  const [userProfile, setUserProfile] = useState<any>(null)
  const [sidebarCollapsed, setSidebarCollapsed] = useState(false)
  const [activeModal, setActiveModal] = useState<string | null>(null)

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

  const toggleSidebar = () => {
    setSidebarCollapsed(!sidebarCollapsed)
  }

  const userName = userProfile?.userFullName || userProfile?.name || userProfile?.firstName || userProfile?.businessName || 'User'

  const helpModals: { [key: string]: { title: string; content: JSX.Element } } = {
    'payment-method': {
      title: 'Update Payment Method',
      content: (
        <div>
          <h4 className="text-lg font-semibold mb-3" style={{ color: '#07382F' }}>How to update your payment method</h4>
          <p className="mb-3">Follow these steps to update your payment information:</p>
          <ol className="list-decimal list-inside space-y-2 mb-4">
            <li>Go to your Account Settings</li>
            <li>Click on "Payment Methods"</li>
            <li>Select "Add New Payment Method"</li>
            <li>Enter your new card details</li>
            <li>Click "Save" to update</li>
          </ol>
          <h4 className="text-lg font-semibold mb-3" style={{ color: '#07382F' }}>Accepted payment methods</h4>
          <ul className="list-disc list-inside space-y-1">
            <li>Visa, Mastercard, American Express</li>
            <li>PayPal</li>
            <li>Bank transfers (for verified accounts)</li>
          </ul>
        </div>
      ),
    },
    'payment-declined': {
      title: 'Payment Declined',
      content: (
        <div>
          <h4 className="text-lg font-semibold mb-3" style={{ color: '#07382F' }}>Common reasons for payment decline</h4>
          <ul className="list-disc list-inside space-y-2 mb-4">
            <li><strong>Insufficient funds:</strong> Your account doesn't have enough balance</li>
            <li><strong>Card expired:</strong> Check your card's expiration date</li>
            <li><strong>Incorrect CVV:</strong> Verify the 3-digit security code</li>
            <li><strong>Bank restrictions:</strong> Contact your bank for assistance</li>
          </ul>
          <h4 className="text-lg font-semibold mb-3" style={{ color: '#07382F' }}>What to do next</h4>
          <p>Try using a different payment method or contact your bank to resolve the issue. If the problem persists, our support team is here to help.</p>
        </div>
      ),
    },
    'refund-request': {
      title: 'Refund Request',
      content: (
        <div>
          <h4 className="text-lg font-semibold mb-3" style={{ color: '#07382F' }}>How to request a refund</h4>
          <p className="mb-3">To request a refund for your order:</p>
          <ol className="list-decimal list-inside space-y-2 mb-4">
            <li>Go to your Order History</li>
            <li>Find the order you want to refund</li>
            <li>Click "Request Refund"</li>
            <li>Select the reason for refund</li>
            <li>Submit your request</li>
          </ol>
          <h4 className="text-lg font-semibold mb-3" style={{ color: '#07382F' }}>Refund processing time</h4>
          <ul className="list-disc list-inside space-y-1">
            <li>Credit card refunds: 5-10 business days</li>
            <li>PayPal refunds: 3-5 business days</li>
            <li>Bank transfers: 7-14 business days</li>
          </ul>
        </div>
      ),
    },
    'billing-questions': {
      title: 'Billing Questions',
      content: (
        <div>
          <h4 className="text-lg font-semibold mb-3" style={{ color: '#07382F' }}>Understanding your bill</h4>
          <p className="mb-3">Your bill includes:</p>
          <ul className="list-disc list-inside space-y-2 mb-4">
            <li><strong>Transaction fees:</strong> Standard 2.9% + $0.30 per transaction</li>
            <li><strong>Processing fees:</strong> Varies by payment method</li>
            <li><strong>Service charges:</strong> Applied for premium features</li>
          </ul>
          <h4 className="text-lg font-semibold mb-3" style={{ color: '#07382F' }}>Need help with billing?</h4>
          <p>Our billing team can help you understand charges, resolve disputes, and provide detailed statements. Contact us for personalized assistance.</p>
        </div>
      ),
    },
    'login-security': {
      title: 'Login & Security',
      content: (
        <div>
          <h4 className="text-lg font-semibold mb-3" style={{ color: '#07382F' }}>Secure your account</h4>
          <p className="mb-3">Protect your account with these security measures:</p>
          <ul className="list-disc list-inside space-y-2 mb-4">
            <li><strong>Two-factor authentication:</strong> Enable 2FA for extra security</li>
            <li><strong>Strong password:</strong> Use a unique, complex password</li>
            <li><strong>Login alerts:</strong> Get notified of new logins</li>
            <li><strong>Session management:</strong> Review active sessions</li>
          </ul>
          <h4 className="text-lg font-semibold mb-3" style={{ color: '#07382F' }}>Security best practices</h4>
          <p>Never share your login credentials, enable 2FA, and regularly review your account activity for any suspicious behavior.</p>
        </div>
      ),
    },
    'update-address': {
      title: 'Update Address',
      content: (
        <div>
          <h4 className="text-lg font-semibold mb-3" style={{ color: '#07382F' }}>How to update your address</h4>
          <p className="mb-3">Keep your address current to ensure smooth order delivery:</p>
          <ol className="list-decimal list-inside space-y-2 mb-4">
            <li>Go to Account Settings</li>
            <li>Click "Profile Information"</li>
            <li>Update your shipping address</li>
            <li>Add billing address if different</li>
            <li>Save your changes</li>
          </ol>
          <h4 className="text-lg font-semibold mb-3" style={{ color: '#07382F' }}>Address verification</h4>
          <p>We may verify your address for security purposes. Please ensure all information is accurate and up-to-date.</p>
        </div>
      ),
    },
    'password-reset': {
      title: 'Password Reset',
      content: (
        <div>
          <h4 className="text-lg font-semibold mb-3" style={{ color: '#07382F' }}>Reset your password</h4>
          <p className="mb-3">If you've forgotten your password:</p>
          <ol className="list-decimal list-inside space-y-2 mb-4">
            <li>Click "Forgot Password" on login page</li>
            <li>Enter your email address</li>
            <li>Check your email for reset link</li>
            <li>Click the link and create new password</li>
            <li>Login with your new password</li>
          </ol>
          <h4 className="text-lg font-semibold mb-3" style={{ color: '#07382F' }}>Password requirements</h4>
          <ul className="list-disc list-inside space-y-1">
            <li>Minimum 8 characters</li>
            <li>Include uppercase and lowercase letters</li>
            <li>Include numbers and special characters</li>
            <li>Don't reuse old passwords</li>
          </ul>
        </div>
      ),
    },
    'privacy-settings': {
      title: 'Privacy Settings',
      content: (
        <div>
          <h4 className="text-lg font-semibold mb-3" style={{ color: '#07382F' }}>Control your privacy</h4>
          <p className="mb-3">Manage how your information is used:</p>
          <ul className="list-disc list-inside space-y-2 mb-4">
            <li><strong>Data sharing:</strong> Control what data we share with partners</li>
            <li><strong>Marketing preferences:</strong> Opt in/out of promotional emails</li>
            <li><strong>Profile visibility:</strong> Control who can see your profile</li>
            <li><strong>Data export:</strong> Download your personal data</li>
          </ul>
          <h4 className="text-lg font-semibold mb-3" style={{ color: '#07382F' }}>Your rights</h4>
          <p>You have the right to access, modify, or delete your personal information at any time through your privacy settings.</p>
        </div>
      ),
    },
    'order-status': {
      title: 'Order Status',
      content: (
        <div>
          <h4 className="text-lg font-semibold mb-3" style={{ color: '#07382F' }}>Track your order</h4>
          <p className="mb-3">Check the status of your order:</p>
          <ol className="list-decimal list-inside space-y-2 mb-4">
            <li>Go to Order History</li>
            <li>Find your order number</li>
            <li>Click "Track Order"</li>
            <li>View real-time updates</li>
          </ol>
          <h4 className="text-lg font-semibold mb-3" style={{ color: '#07382F' }}>Order statuses</h4>
          <ul className="list-disc list-inside space-y-1">
            <li><strong>Processing:</strong> Order confirmed, preparing for shipment</li>
            <li><strong>Shipped:</strong> Order is on its way</li>
            <li><strong>Delivered:</strong> Order has been received</li>
            <li><strong>Cancelled:</strong> Order was cancelled</li>
          </ul>
        </div>
      ),
    },
    'shipping-issues': {
      title: 'Shipping Issues',
      content: (
        <div>
          <h4 className="text-lg font-semibold mb-3" style={{ color: '#07382F' }}>Common shipping problems</h4>
          <p className="mb-3">If you're experiencing shipping issues:</p>
          <ul className="list-disc list-inside space-y-2 mb-4">
            <li><strong>Delayed delivery:</strong> Check tracking for updates</li>
            <li><strong>Package lost:</strong> Contact our support team</li>
            <li><strong>Damaged items:</strong> Document damage and contact us</li>
            <li><strong>Wrong address:</strong> Verify your shipping address</li>
          </ul>
          <h4 className="text-lg font-semibold mb-3" style={{ color: '#07382F' }}>What we can do</h4>
          <p>We'll work with the shipping carrier to resolve issues and ensure you receive your order or a full refund if necessary.</p>
        </div>
      ),
    },
    'product-questions': {
      title: 'Product Questions',
      content: (
        <div>
          <h4 className="text-lg font-semibold mb-3" style={{ color: '#07382F' }}>Get product information</h4>
          <p className="mb-3">Find answers about our products:</p>
          <ul className="list-disc list-inside space-y-2 mb-4">
            <li><strong>Product specifications:</strong> Detailed technical information</li>
            <li><strong>Usage guidelines:</strong> How to use products safely</li>
            <li><strong>Quality standards:</strong> Our quality assurance process</li>
            <li><strong>Origin information:</strong> Where products come from</li>
          </ul>
          <h4 className="text-lg font-semibold mb-3" style={{ color: '#07382F' }}>Need more details?</h4>
          <p>Our product specialists can answer specific questions about ingredients, sourcing, and quality standards. Contact us for detailed information.</p>
        </div>
      ),
    },
    'return-policy': {
      title: 'Return Policy',
      content: (
        <div>
          <h4 className="text-lg font-semibold mb-3" style={{ color: '#07382F' }}>Our return policy</h4>
          <p className="mb-3">We want you to be completely satisfied with your purchase:</p>
          <ul className="list-disc list-inside space-y-2 mb-4">
            <li><strong>30-day return window:</strong> Return items within 30 days</li>
            <li><strong>Original condition:</strong> Items must be unused and in original packaging</li>
            <li><strong>Free returns:</strong> We cover return shipping costs</li>
            <li><strong>Full refund:</strong> Get your money back or exchange</li>
          </ul>
          <h4 className="text-lg font-semibold mb-3" style={{ color: '#07382F' }}>Return process</h4>
          <p>Initiate a return through your order history, print a shipping label, and send the item back. Refunds are processed within 5-10 business days.</p>
        </div>
      ),
    },
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

        {/* Help Content */}
        <div className="p-4 md:p-6">
          <div className="max-w-4xl mx-auto">
            {/* Welcome Section */}
            <div className="bg-gradient-to-br from-white via-gray-50 to-white rounded-xl shadow-lg p-8 mb-6 border border-gray-200 relative overflow-hidden">
              <div className="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-[#07382F]/5 to-transparent rounded-full blur-3xl"></div>
              <div className="relative z-10">
                <h1 className="text-4xl font-bold mb-4 bg-gradient-to-r from-[#07382F] to-[#0d5a4a] bg-clip-text text-transparent">
                  Hello there! 👋
                </h1>
                <p className="text-lg text-gray-700 leading-relaxed">
                  Welcome to ViaNexta Exchange support. You can quickly fix your problem here, or we'll connect you to someone who can.
                </p>
              </div>
            </div>

            {/* Help Categories */}
            <div className="bg-gradient-to-br from-white to-gray-50/50 rounded-xl shadow-lg hover:shadow-xl p-6 mb-6 border border-gray-200 transition-all duration-300">
              <div className="mb-5 pb-3 border-b-2" style={{ borderColor: '#07382F' }}>
                <h4 className="text-xl font-bold mb-0" style={{ color: '#07382F' }}>
                  <i className="fa fa-credit-card mr-2"></i>Payment Issues
                </h4>
              </div>
              <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <button
                  onClick={() => setActiveModal('payment-method')}
                  className="px-5 py-3.5 border-2 rounded-lg text-center font-semibold transition-all duration-200 hover:shadow-lg hover:scale-[1.02] transform"
                  style={{ borderColor: '#07382F', color: '#07382F' }}
                >
                  <i className="fa fa-credit-card mr-2"></i>Update payment method
                </button>
                <button
                  onClick={() => setActiveModal('payment-declined')}
                  className="px-5 py-3.5 border-2 rounded-lg text-center font-semibold transition-all duration-200 hover:shadow-lg hover:scale-[1.02] transform"
                  style={{ borderColor: '#07382F', color: '#07382F' }}
                >
                  <i className="fa fa-exclamation-triangle mr-2"></i>Payment declined
                </button>
                <button
                  onClick={() => setActiveModal('refund-request')}
                  className="px-5 py-3.5 border-2 rounded-lg text-center font-semibold transition-all duration-200 hover:shadow-lg hover:scale-[1.02] transform"
                  style={{ borderColor: '#07382F', color: '#07382F' }}
                >
                  <i className="fa fa-undo mr-2"></i>Refund request
                </button>
                <button
                  onClick={() => setActiveModal('billing-questions')}
                  className="px-5 py-3.5 border-2 rounded-lg text-center font-semibold transition-all duration-200 hover:shadow-lg hover:scale-[1.02] transform"
                  style={{ borderColor: '#07382F', color: '#07382F' }}
                >
                  <i className="fa fa-file-invoice-dollar mr-2"></i>Billing questions
                </button>
              </div>
            </div>

            <div className="bg-gradient-to-br from-white to-gray-50/50 rounded-xl shadow-lg hover:shadow-xl p-6 mb-6 border border-gray-200 transition-all duration-300">
              <div className="mb-5 pb-3 border-b-2" style={{ borderColor: '#07382F' }}>
                <h4 className="text-xl font-bold mb-0" style={{ color: '#07382F' }}>
                  <i className="fa fa-shield-alt mr-2"></i>Account & Security
                </h4>
              </div>
              <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <button
                  onClick={() => setActiveModal('login-security')}
                  className="px-5 py-3.5 border-2 rounded-lg text-center font-semibold transition-all duration-200 hover:shadow-lg hover:scale-[1.02] transform"
                  style={{ borderColor: '#07382F', color: '#07382F' }}
                >
                  <i className="fa fa-lock mr-2"></i>Login & Security
                </button>
                <button
                  onClick={() => setActiveModal('update-address')}
                  className="px-5 py-3.5 border-2 rounded-lg text-center font-semibold transition-all duration-200 hover:shadow-lg hover:scale-[1.02] transform"
                  style={{ borderColor: '#07382F', color: '#07382F' }}
                >
                  <i className="fa fa-map-marker-alt mr-2"></i>Update address
                </button>
                <button
                  onClick={() => setActiveModal('password-reset')}
                  className="px-5 py-3.5 border-2 rounded-lg text-center font-semibold transition-all duration-200 hover:shadow-lg hover:scale-[1.02] transform"
                  style={{ borderColor: '#07382F', color: '#07382F' }}
                >
                  <i className="fa fa-key mr-2"></i>Password reset
                </button>
                <button
                  onClick={() => setActiveModal('privacy-settings')}
                  className="px-5 py-3.5 border-2 rounded-lg text-center font-semibold transition-all duration-200 hover:shadow-lg hover:scale-[1.02] transform"
                  style={{ borderColor: '#07382F', color: '#07382F' }}
                >
                  <i className="fa fa-user-shield mr-2"></i>Privacy settings
                </button>
              </div>
            </div>

            <div className="bg-gradient-to-br from-white to-gray-50/50 rounded-xl shadow-lg hover:shadow-xl p-6 mb-6 border border-gray-200 transition-all duration-300">
              <div className="mb-5 pb-3 border-b-2" style={{ borderColor: '#07382F' }}>
                <h4 className="text-xl font-bold mb-0" style={{ color: '#07382F' }}>
                  <i className="fa fa-shopping-bag mr-2"></i>Trading & Orders
                </h4>
              </div>
              <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <button
                  onClick={() => setActiveModal('order-status')}
                  className="px-5 py-3.5 border-2 rounded-lg text-center font-semibold transition-all duration-200 hover:shadow-lg hover:scale-[1.02] transform"
                  style={{ borderColor: '#07382F', color: '#07382F' }}
                >
                  <i className="fa fa-clipboard-list mr-2"></i>Order status
                </button>
                <button
                  onClick={() => setActiveModal('shipping-issues')}
                  className="px-5 py-3.5 border-2 rounded-lg text-center font-semibold transition-all duration-200 hover:shadow-lg hover:scale-[1.02] transform"
                  style={{ borderColor: '#07382F', color: '#07382F' }}
                >
                  <i className="fa fa-truck mr-2"></i>Shipping issues
                </button>
                <button
                  onClick={() => setActiveModal('product-questions')}
                  className="px-5 py-3.5 border-2 rounded-lg text-center font-semibold transition-all duration-200 hover:shadow-lg hover:scale-[1.02] transform"
                  style={{ borderColor: '#07382F', color: '#07382F' }}
                >
                  <i className="fa fa-question-circle mr-2"></i>Product questions
                </button>
                <button
                  onClick={() => setActiveModal('return-policy')}
                  className="px-5 py-3.5 border-2 rounded-lg text-center font-semibold transition-all duration-200 hover:shadow-lg hover:scale-[1.02] transform"
                  style={{ borderColor: '#07382F', color: '#07382F' }}
                >
                  <i className="fa fa-undo-alt mr-2"></i>Return policy
                </button>
              </div>
            </div>

            {/* Contact Section */}
            <div className="bg-gradient-to-br from-[#07382F] via-[#0d5a4a] to-[#07382F] rounded-xl shadow-xl p-8 text-white text-center relative overflow-hidden">
              <div className="absolute inset-0 bg-gradient-to-br from-transparent via-white/5 to-transparent animate-pulse"></div>
              <div className="relative z-10">
                <h3 className="text-3xl font-bold mb-3 drop-shadow-lg">Still need help?</h3>
                <p className="mb-6 text-lg drop-shadow-md">Our support team is here to help you with any questions or concerns.</p>
                <div className="flex flex-col sm:flex-row gap-4 justify-center">
                  <a
                    href="mailto:winner@winwin.coffee?cc=matthew@winwin.coffee,nikisha@winwin.coffee"
                    className="px-8 py-3.5 bg-white text-[#07382F] rounded-lg font-bold hover:bg-gray-100 transition-all duration-200 hover:shadow-xl hover:scale-105 transform"
                  >
                    <i className="fa fa-envelope mr-2"></i>Email us
                  </a>
                  <a
                    href="tel:+1234567890"
                    className="px-8 py-3.5 bg-white text-[#07382F] rounded-lg font-bold hover:bg-gray-100 transition-all duration-200 hover:shadow-xl hover:scale-105 transform"
                  >
                    <i className="fa fa-phone mr-2"></i>Call us
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Help Modal */}
      {activeModal && helpModals[activeModal] && (
        <div className="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
          <div className="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div className="bg-gradient-to-r from-[#07382F] to-[#0a4a3a] text-white p-6 rounded-t-lg">
              <div className="flex justify-between items-center">
                <h3 className="text-xl font-bold">{helpModals[activeModal].title}</h3>
                <button
                  onClick={() => setActiveModal(null)}
                  className="text-white hover:text-gray-200"
                >
                  <i className="fa fa-times text-xl"></i>
                </button>
              </div>
            </div>
            <div className="p-6">
              {helpModals[activeModal].content}
            </div>
            <div className="p-6 border-t border-gray-200 bg-gray-50 rounded-b-lg text-center">
              <button
                onClick={() => setActiveModal(null)}
                className="px-6 py-2 rounded text-white font-medium mr-2"
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

export default BuyerHelp


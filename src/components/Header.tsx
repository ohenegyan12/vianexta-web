import { useState } from 'react'
import { Link, useNavigate } from 'react-router-dom'
import logo from '../../assets/vianexta-logo.svg'
import buyLogo from '../../assets/buy-logo.svg'

interface HeaderProps {
  isBuyMode: boolean
}

function Header({ isBuyMode }: HeaderProps) {
  const navigate = useNavigate()
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false)
  const [showLogoutConfirm, setShowLogoutConfirm] = useState(false)
  const currentLogo = isBuyMode ? buyLogo : logo

  const handleSmoothScroll = (e: React.MouseEvent<HTMLAnchorElement>, targetId: string) => {
    e.preventDefault()
    const element = document.getElementById(targetId)
    if (element) {
      const headerOffset = 80 // Account for fixed header height
      const elementPosition = element.getBoundingClientRect().top
      const offsetPosition = elementPosition + window.pageYOffset - headerOffset

      window.scrollTo({
        top: offsetPosition,
        behavior: 'smooth'
      })
    }
    setIsMobileMenuOpen(false)
  }

  const handleContactClick = (e: React.MouseEvent<HTMLAnchorElement>) => {
    e.preventDefault()
    navigate('/contact')
    setIsMobileMenuOpen(false)
  }
  return (
    <header className={`fixed top-0 left-0 right-0 z-40 w-full ${isBuyMode ? 'bg-[#09543D]' : 'bg-[#F9F7F1]'} transition-colors duration-300 shadow-sm`}>
      {/* Top dark bar */}
      <div className="bg-gray-900 h-1"></div>

      {/* Main navigation */}
      <div className={`${isBuyMode ? 'bg-[#09543D]' : 'bg-[#F9F7F1]'} transition-colors duration-300`}>
        <div className="container mx-auto px-4 xl:px-6">
          <nav className="flex items-center justify-between py-4 relative">
            {/* Mobile: Logo in top-left */}
            <div className="lg:hidden">
              <a href="/">
                <img src={currentLogo} alt="Vianexta" className="h-8" />
              </a>
            </div>

            {/* Desktop: Left navigation links */}
            <div className="hidden lg:flex items-center gap-8 xl:gap-12 lg:-ml-8 xl:-ml-16">
              <a
                href="#how-it-works"
                onClick={(e) => handleSmoothScroll(e, 'how-it-works')}
                className={`${isBuyMode ? 'text-white' : 'text-[#09543D]'} hover:opacity-80 transition-opacity whitespace-nowrap cursor-pointer`}
              >
                How it Works
              </a>
              <a
                href="#why-choose-us"
                onClick={(e) => handleSmoothScroll(e, 'why-choose-us')}
                className={`${isBuyMode ? 'text-white' : 'text-[#09543D]'} hover:opacity-80 transition-opacity whitespace-nowrap cursor-pointer`}
              >
                Why Choose Us
              </a>
              <a
                href="#testimonials"
                onClick={(e) => handleSmoothScroll(e, 'testimonials')}
                className={`${isBuyMode ? 'text-white' : 'text-[#09543D]'} hover:opacity-80 transition-opacity whitespace-nowrap cursor-pointer`}
              >
                Testimonials
              </a>
              <a
                href="/contact"
                onClick={handleContactClick}
                className={`${isBuyMode ? 'text-white' : 'text-[#09543D]'} hover:opacity-80 transition-opacity whitespace-nowrap cursor-pointer`}
              >
                Contact
              </a>
            </div>

            {/* Desktop: Center logo - absolutely positioned */}
            <div className="hidden lg:block absolute left-1/2 transform -translate-x-1/2">
              <a href="/">
                <img src={currentLogo} alt="Vianexta" className="h-10" />
              </a>
            </div>

            {/* Mobile: Hamburger menu */}
            <div className="lg:hidden">
              <button
                onClick={() => setIsMobileMenuOpen(true)}
                className={`${isBuyMode ? 'text-white' : 'text-[#09543D]'} p-2`}
              >
                <svg className="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3.5} d="M4 6h16M4 12h16M4 18h16" />
                </svg>
              </button>
            </div>

            {/* Desktop: Right navigation and buttons */}
            <div className="hidden lg:flex items-center gap-4 xl:gap-12 lg:-mr-4 xl:-mr-8">
              <div className="flex items-center gap-3 xl:gap-4 lg:ml-4 xl:ml-8">
                {/* Dynamic Auth Header */}
                {(() => {
                  const userStr = localStorage.getItem('user')
                  const userProfile = userStr ? JSON.parse(userStr) : null
                  const isAuthenticated = !!userProfile

                  if (isAuthenticated) {
                    return (
                      <div className="flex items-center gap-3">
                        {/* User Name Pill */}
                        <div className="bg-gradient-to-r from-[#09543D] to-[#0d6b4f] rounded-full px-5 py-2.5 shadow-md">
                          <span
                            className="text-white font-medium text-sm tracking-wide"
                            style={{
                              fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                              letterSpacing: '0.5px'
                            }}
                          >
                            Hi, {userProfile?.userFullName || userProfile?.name || userProfile?.firstName || userProfile?.businessName || 'User'}
                          </span>
                        </div>

                        {/* Dashboard Button */}
                        <Link
                          to="/buyer"
                          className="w-11 h-11 rounded-full bg-white border-2 border-gray-100 flex items-center justify-center hover:border-[#09543D] hover:bg-[#09543D]/5 transition-all duration-200 shadow-sm hover:shadow-md group"
                          aria-label="Dashboard"
                        >
                          <svg className="w-5 h-5 text-gray-600 group-hover:text-[#09543D] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                          </svg>
                        </Link>

                        {/* Logout Button */}
                        <button
                          onClick={() => setShowLogoutConfirm(true)}
                          className="w-11 h-11 rounded-full bg-white border-2 border-gray-100 flex items-center justify-center hover:border-red-500 hover:bg-red-50 transition-all duration-200 shadow-sm hover:shadow-md group"
                          aria-label="Logout"
                        >
                          <svg className="w-5 h-5 text-gray-600 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                          </svg>
                        </button>
                      </div>
                    )
                  }

                  // Default Unauthenticated View
                  return (
                    <>
                      <Link
                        to="/signin"
                        className={`px-6 py-2 rounded-full transition-colors ${isBuyMode
                          ? 'border border-white text-white bg-transparent hover:bg-white hover:text-[#09543D]'
                          : 'border border-[#09543D] text-[#09543D] bg-[#F9F7F1] hover:bg-[#09543D] hover:text-white'
                          }`}
                      >
                        Sign in
                      </Link>
                      <Link
                        to="/signup"
                        className={`px-6 py-2 rounded-full transition-opacity ${isBuyMode
                          ? 'bg-white text-[#09543D] hover:opacity-90'
                          : 'bg-[#09543D] text-white hover:opacity-90'
                          }`}
                      >
                        Get Started
                      </Link>
                    </>
                  )
                })()}
              </div>
            </div>
          </nav>
        </div>
      </div>

      {/* Mobile Menu Modal */}
      {isMobileMenuOpen && (
        <div
          className="fixed inset-0 z-50 lg:hidden"
          onClick={() => setIsMobileMenuOpen(false)}
        >
          {/* Backdrop */}
          <div className="absolute inset-0 bg-black bg-opacity-50"></div>

          {/* Menu Panel */}
          <div
            className={`absolute right-0 top-0 h-full w-80 max-w-[85vw] ${isBuyMode ? 'bg-[#09543D]' : 'bg-[#F9F7F1]'} shadow-xl overflow-y-auto`}
            onClick={(e) => e.stopPropagation()}
          >
            {/* Header with close button */}
            <div className="flex items-center justify-between p-4 border-b border-opacity-20" style={{ borderColor: isBuyMode ? 'rgba(255,255,255,0.2)' : 'rgba(9,84,61,0.2)' }}>
              <img src={currentLogo} alt="Vianexta" className="h-8" />
              <button
                onClick={() => setIsMobileMenuOpen(false)}
                className={`${isBuyMode ? 'text-white' : 'text-[#09543D]'} p-2`}
              >
                <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>

            {/* Navigation Links */}
            <nav className="flex flex-col p-4 space-y-4">
              <a
                href="#how-it-works"
                onClick={(e) => handleSmoothScroll(e, 'how-it-works')}
                className={`${isBuyMode ? 'text-white' : 'text-[#09543D]'} text-lg font-medium hover:opacity-80 transition-opacity py-2 cursor-pointer`}
              >
                How it Works
              </a>
              <a
                href="#why-choose-us"
                onClick={(e) => handleSmoothScroll(e, 'why-choose-us')}
                className={`${isBuyMode ? 'text-white' : 'text-[#09543D]'} text-lg font-medium hover:opacity-80 transition-opacity py-2 cursor-pointer`}
              >
                Why Choose Us
              </a>
              <a
                href="#testimonials"
                onClick={(e) => handleSmoothScroll(e, 'testimonials')}
                className={`${isBuyMode ? 'text-white' : 'text-[#09543D]'} text-lg font-medium hover:opacity-80 transition-opacity py-2 cursor-pointer`}
              >
                Testimonials
              </a>
              <a
                href="/contact"
                onClick={handleContactClick}
                className={`${isBuyMode ? 'text-white' : 'text-[#09543D]'} text-lg font-medium hover:opacity-80 transition-opacity py-2 cursor-pointer`}
              >
                Contact
              </a>
            </nav>

            {/* Buttons */}
            <div className="p-4 space-y-3 border-t border-opacity-20 mt-4" style={{ borderColor: isBuyMode ? 'rgba(255,255,255,0.2)' : 'rgba(9,84,61,0.2)' }}>
              <Link
                to="/signin"
                onClick={() => setIsMobileMenuOpen(false)}
                className={`w-full px-6 py-3 rounded-full transition-colors text-center block ${isBuyMode
                  ? 'border border-white text-white bg-transparent hover:bg-white hover:text-[#09543D]'
                  : 'border border-[#09543D] text-[#09543D] bg-[#F9F7F1] hover:bg-[#09543D] hover:text-white'
                  }`}
              >
                Sign in
              </Link>
              <Link
                to="/signup"
                onClick={() => setIsMobileMenuOpen(false)}
                className={`w-full px-6 py-3 rounded-full transition-opacity text-center block ${isBuyMode
                  ? 'bg-white text-[#09543D] hover:opacity-90'
                  : 'bg-[#09543D] text-white hover:opacity-90'
                  }`}
              >
                Get Started
              </Link>
            </div>
          </div>
        </div>
      )}

      {/* Logout Confirmation Modal */}
      {showLogoutConfirm && (
        <div
          className="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
          onClick={() => setShowLogoutConfirm(false)}
        >
          <div
            className="bg-white rounded-2xl p-8 lg:p-10 max-w-md w-full shadow-2xl transform transition-all"
            onClick={(e) => e.stopPropagation()}
          >
            <div className="text-center">
              {/* Title */}
              <h3
                className="text-3xl lg:text-4xl font-medium text-gray-900 mb-4"
                style={{
                  fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                  letterSpacing: '1px'
                }}
              >
                Confirm Logout
              </h3>

              {/* Message */}
              <p className="text-gray-600 text-lg mb-6">
                Are you sure you want to logout? You will need to sign in again to access your account.
              </p>

              {/* Buttons */}
              <div className="flex gap-4 justify-center">
                <button
                  onClick={() => setShowLogoutConfirm(false)}
                  className="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-medium hover:bg-gray-300 transition-all duration-200"
                  style={{
                    fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                  }}
                >
                  Cancel
                </button>
                <button
                  onClick={() => {
                    setShowLogoutConfirm(false)
                    localStorage.removeItem('authToken')
                    localStorage.removeItem('user')
                    window.location.reload()
                  }}
                  className="px-6 py-3 bg-red-600 text-white rounded-xl font-medium hover:bg-red-700 transition-all duration-200 shadow-lg hover:shadow-xl"
                  style={{
                    fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                  }}
                >
                  Logout
                </button>
              </div>
            </div>
          </div>
        </div>
      )}
    </header>
  )
}

export default Header

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
    <header>
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
                <Link 
                  to="/signin"
                  className={`px-6 py-2 rounded-full transition-colors ${
                    isBuyMode 
                      ? 'border border-white text-white bg-transparent hover:bg-white hover:text-[#09543D]' 
                      : 'border border-[#09543D] text-[#09543D] bg-[#F9F7F1] hover:bg-[#09543D] hover:text-white'
                  }`}
                >
                  Sign in
                </Link>
                <Link 
                  to="/signup"
                  className={`px-6 py-2 rounded-full transition-opacity ${
                    isBuyMode 
                      ? 'bg-white text-[#09543D] hover:opacity-90' 
                      : 'bg-[#09543D] text-white hover:opacity-90'
                  }`}
                >
                  Get Started
                </Link>
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
                className={`w-full px-6 py-3 rounded-full transition-colors text-center block ${
                  isBuyMode 
                    ? 'border border-white text-white bg-transparent hover:bg-white hover:text-[#09543D]' 
                    : 'border border-[#09543D] text-[#09543D] bg-[#F9F7F1] hover:bg-[#09543D] hover:text-white'
                }`}
              >
                Sign in
              </Link>
              <Link 
                to="/signup"
                onClick={() => setIsMobileMenuOpen(false)}
                className={`w-full px-6 py-3 rounded-full transition-opacity text-center block ${
                  isBuyMode 
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
    </header>
  )
}

export default Header


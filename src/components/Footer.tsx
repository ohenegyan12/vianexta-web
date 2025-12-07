import { useState, useRef } from 'react'
import footerLogo from '../../assets/footer-logo.png'

function Footer() {
  const [email, setEmail] = useState('')
  const mobileInputRef = useRef<HTMLInputElement>(null)
  const desktopInputRef = useRef<HTMLInputElement>(null)

  const handleSubscribe = (e: React.FormEvent) => {
    e.preventDefault()
    // Handle subscription logic here
    console.log('Subscribing:', email)
    setEmail('')
  }

  const handleInputFocus = (e: React.FocusEvent<HTMLInputElement>) => {
    // Smoothly scroll the input into view when focused
    setTimeout(() => {
      e.target.scrollIntoView({ 
        behavior: 'smooth', 
        block: 'center',
        inline: 'nearest'
      })
    }, 300) // Small delay to allow keyboard to start appearing
  }

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
  }

  return (
    <footer id="careers" className="bg-white py-12 md:py-16">
      <div className="container mx-auto px-4">
        {/* Main Footer Content */}
        <div className="mb-8 md:mb-12">
          {/* Logo Section */}
          <div className="mb-8 md:mb-0">
            <img 
              src={footerLogo} 
              alt="ViaNexta" 
              className="h-12 md:h-16 w-auto mb-4"
            />
          </div>

          {/* Company and Quick Links - Side by Side on Mobile */}
          <div className="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-5 gap-8 md:gap-12 mb-8 md:mb-0">
            {/* Quick Links */}
            <div>
              <h3 
                className="font-bold text-gray-900 mb-4 text-base md:text-lg"
                style={{
                  fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                }}
              >
                Quick Links
              </h3>
              <ul className="space-y-2">
                <li>
                  <a 
                    href="#why-choose-us" 
                    onClick={(e) => handleSmoothScroll(e, 'why-choose-us')}
                    className="text-gray-600 hover:text-[#09543D] transition-colors text-sm md:text-base"
                  >
                    Why Choose Us
                  </a>
                </li>
                <li>
                  <a 
                    href="#how-it-works" 
                    onClick={(e) => handleSmoothScroll(e, 'how-it-works')}
                    className="text-gray-600 hover:text-[#09543D] transition-colors text-sm md:text-base"
                  >
                    How It Works
                  </a>
                </li>
                <li>
                  <a 
                    href="#testimonials" 
                    onClick={(e) => handleSmoothScroll(e, 'testimonials')}
                    className="text-gray-600 hover:text-[#09543D] transition-colors text-sm md:text-base"
                  >
                    Testimonials
                  </a>
                </li>
                <li>
                  <a 
                    href="#faq" 
                    onClick={(e) => handleSmoothScroll(e, 'faq')}
                    className="text-gray-600 hover:text-[#09543D] transition-colors text-sm md:text-base"
                  >
                    FAQ's
                  </a>
                </li>
              </ul>
            </div>

            {/* Company */}
            <div>
              <h3 
                className="font-bold text-gray-900 mb-4 text-base md:text-lg"
                style={{
                  fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                }}
              >
                Company
              </h3>
              <ul className="space-y-2">
                <li>
                  <a href="/careers" className="text-gray-600 hover:text-[#09543D] transition-colors text-sm md:text-base">
                    Work With Us
                  </a>
                </li>
                <li>
                  <a href="/contact" className="text-gray-600 hover:text-[#09543D] transition-colors text-sm md:text-base">
                    Contact Us
                  </a>
                </li>
              </ul>
            </div>

            {/* Others */}
            <div>
              <h3 
                className="font-bold text-gray-900 mb-4 text-base md:text-lg"
                style={{
                  fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                }}
              >
                Others
              </h3>
              <ul className="space-y-2">
                <li>
                  <a href="/careers" className="text-gray-600 hover:text-[#09543D] transition-colors text-sm md:text-base">
                    Careers
                  </a>
                </li>
                <li>
                  <a href="/recommend" className="text-gray-600 hover:text-[#09543D] transition-colors text-sm md:text-base">
                    Recommend
                  </a>
                </li>
              </ul>
            </div>

            {/* Stay Updated - Hidden on mobile, shown on md+ */}
            <div className="hidden md:block lg:col-span-2">
              <h3 
                className="font-bold text-gray-900 mb-4 text-base md:text-lg"
                style={{
                  fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                }}
              >
                Stay Updated
              </h3>
              <p className="text-gray-600 text-sm md:text-base mb-4">
                Get the latest updates and exclusive offers delivered to your inbox.
              </p>
              <form onSubmit={handleSubscribe} className="flex gap-2">
                <input
                  ref={desktopInputRef}
                  type="email"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  onFocus={handleInputFocus}
                  placeholder="Enter your email"
                  className="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#09543D] text-sm md:text-base"
                  required
                />
                <button
                  type="submit"
                  className="bg-[#09543D] text-white px-4 md:px-6 py-2 rounded-lg hover:bg-[#09543D]/90 transition-colors text-sm md:text-base font-medium whitespace-nowrap"
                >
                  Subscribe
                </button>
              </form>
            </div>
          </div>

          {/* Stay Updated - Mobile Only (at bottom) */}
          <div className="md:hidden">
            <h3 
              className="font-bold text-gray-900 mb-4 text-base"
              style={{
                fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
              }}
            >
              Stay Updated
            </h3>
            <p className="text-gray-600 text-sm mb-4">
              Get the latest updates and exclusive offers delivered to your inbox.
            </p>
            <form onSubmit={handleSubscribe} className="flex gap-2">
              <input
                ref={mobileInputRef}
                type="email"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                onFocus={handleInputFocus}
                placeholder="Enter your email"
                className="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#09543D] text-sm"
                required
              />
              <button
                type="submit"
                className="bg-[#09543D] text-white px-4 py-2 rounded-lg hover:bg-[#09543D]/90 transition-colors text-sm font-medium whitespace-nowrap"
              >
                Subscribe
              </button>
            </form>
          </div>
        </div>

        {/* Bottom Section */}
        <div className="border-t border-gray-300 pt-6 md:pt-8">
          <div className="flex flex-col md:flex-row justify-between items-center gap-4">
            <p className="text-gray-500 text-xs md:text-sm">
              2025 © ViaNexta | All Rights Reserved.
            </p>
            <div className="flex flex-wrap items-center gap-4 md:gap-6 text-xs md:text-sm">
              <a href="/privacy" className="text-gray-500 hover:text-[#09543D] transition-colors">
                Privacy Policy
              </a>
              <span className="text-gray-300">|</span>
              <a href="/terms" className="text-gray-500 hover:text-[#09543D] transition-colors">
                Terms of Service
              </a>
              <span className="text-gray-300">|</span>
              <a href="#help" className="text-gray-500 hover:text-[#09543D] transition-colors">
                Get Help
              </a>
            </div>
          </div>
        </div>
      </div>
    </footer>
  )
}

export default Footer


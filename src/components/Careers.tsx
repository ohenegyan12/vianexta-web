import { Link } from 'react-router-dom'
import buyLogo from '../../assets/buy-logo.svg'
import ChatButton from './ChatButton'

function Careers() {
  return (
    <div className="min-h-screen flex flex-col bg-white">
      {/* Header - Fixed with background on mobile */}
      <header className="fixed lg:absolute top-0 left-0 right-0 z-50 bg-white lg:bg-transparent border-b border-gray-200 lg:border-none">
        <div className="w-full py-4 px-4 lg:px-12">
          <div className="flex items-center justify-between">
            <Link to="/" className="flex items-center gap-2 z-10 relative">
              <img src={buyLogo} alt="ViaNexta" className="h-8" />
            </Link>
            <div className="flex items-center gap-4 z-10 relative">
              <button className="text-gray-600 hover:text-[#09543D] transition-colors">
                <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
              </button>
              <button className="text-gray-600 hover:text-[#09543D] transition-colors">
                <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </header>

      {/* Main Content - Split Layout */}
      <div className="min-h-screen flex flex-col lg:flex-row pt-16 lg:pt-0">
        {/* Left Section - Content */}
        <div className="lg:w-1/2 bg-[#1E4637] p-8 lg:p-12 flex flex-col justify-center">
          <div className="max-w-md">
            <h1 
              className="text-5xl font-bold mb-6 text-white"
              style={{
                fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                letterSpacing: '-1.3px',
                lineHeight: '1.1'
              }}
            >
              Work with us
            </h1>
            <p className="text-lg text-white mb-8 leading-relaxed">
              Welcome to ViaNexta – where passion meets precision in the world of coffee. If you're enthusiastic about fostering relationships, fueled by a love for coffee, and dedicated to excellence, we might just be the perfect blend.
            </p>
            
            <h2 
              className="text-3xl font-bold mb-4 text-white"
              style={{
                fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                letterSpacing: '-1px',
                lineHeight: '1.1'
              }}
            >
              How to apply
            </h2>
            <p className="text-lg text-white mb-6 leading-relaxed">
              Ready to be a part of our coffee journey? Send us a message on our socials. Be sure to let us know why you're the perfect fit for ViaNexta or how best we can work on a partnership.
            </p>
            
            <p className="text-base text-white/90 leading-relaxed">
              ViaNexta is an equal opportunity employer. We celebrate diversity and are committed to creating an inclusive environment for all employees.
            </p>
          </div>
        </div>

        {/* Right Section - Social Media */}
        <div className="flex-1 lg:w-1/2 flex flex-col p-8 lg:p-12 bg-white justify-center items-center overflow-y-auto">
          <div className="w-full max-w-2xl text-center">
            {/* Social Media Links */}
            <div>
              <p className="text-gray-600 mb-8 text-xl md:text-2xl lg:text-3xl font-bold">
                Connect with us on social media:
              </p>
              <div className="flex justify-center gap-8 md:gap-12">
                <a 
                  href="https://linkedin.com/company/vianexta" 
                  target="_blank" 
                  rel="noopener noreferrer"
                  className="text-[#09543D] hover:text-[#09543D]/80 transition-colors"
                >
                  <svg className="w-16 h-16 md:w-20 md:h-20 lg:w-24 lg:h-24" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                  </svg>
                </a>
                <a 
                  href="https://twitter.com/vianexta" 
                  target="_blank" 
                  rel="noopener noreferrer"
                  className="text-[#09543D] hover:text-[#09543D]/80 transition-colors"
                >
                  <svg className="w-16 h-16 md:w-20 md:h-20 lg:w-24 lg:h-24" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                  </svg>
                </a>
                <a 
                  href="https://instagram.com/vianexta" 
                  target="_blank" 
                  rel="noopener noreferrer"
                  className="text-[#09543D] hover:text-[#09543D]/80 transition-colors"
                >
                  <svg className="w-16 h-16 md:w-20 md:h-20 lg:w-24 lg:h-24" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                  </svg>
                </a>
              </div>
            </div>

            {/* Back to Home */}
            <div className="mt-12">
              <Link 
                to="/" 
                className="text-[#09543D] font-semibold hover:underline text-sm md:text-base"
              >
                ← Back to home
              </Link>
            </div>
          </div>
        </div>
      </div>

      {/* Chat Button */}
      <ChatButton />
    </div>
  )
}

export default Careers

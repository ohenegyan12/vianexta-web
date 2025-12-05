import { useState, useRef, useEffect } from 'react'
import { Link } from 'react-router-dom'
import vianextaLogo from '../../assets/vianexta-logo.svg'
import buyLogo from '../../assets/buy-logo.svg'
import roastedIcon from '../../assets/roasted.svg'
import wholesaleBrandsIcon from '../../assets/wholesale-brands.svg'
import singleOriginIcon from '../../assets/single-origin.svg'
import blendIcon from '../../assets/blend.svg'
import ChatButton from './ChatButton'

function BuyerWizard() {
  const [selectedType, setSelectedType] = useState<string>('')
  const [selectedCoffeeType, setSelectedCoffeeType] = useState<string>('')
  const [currentPage, setCurrentPage] = useState(1)
  const [showCoffeeType, setShowCoffeeType] = useState(false)
  const [showSingleOrigin, setShowSingleOrigin] = useState(false)
  const totalPages = 2
  const coffeeTypeSectionRef = useRef<HTMLDivElement>(null)
  const singleOriginSectionRef = useRef<HTMLDivElement>(null)

  useEffect(() => {
    if (selectedType === 'roasted') {
      setTimeout(() => setShowCoffeeType(true), 50)
    } else {
      setShowCoffeeType(false)
      setShowSingleOrigin(false)
    }
  }, [selectedType])

  useEffect(() => {
    if (selectedCoffeeType === 'single-origin') {
      setTimeout(() => setShowSingleOrigin(true), 50)
    } else {
      setShowSingleOrigin(false)
    }
  }, [selectedCoffeeType])

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
              {/* User name */}
              <div className="bg-gradient-to-r from-[#09543D] to-[#0d6b4f] rounded-full px-5 py-2.5 shadow-md hover:shadow-lg transition-all duration-200">
                <span 
                  className="text-white font-bold text-sm lg:text-base tracking-tight"
                  style={{
                    fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                  }}
                >
                  Ohene Gyan
                </span>
              </div>

              {/* Dashboard icon */}
              <button 
                className="w-11 h-11 lg:w-12 lg:h-12 rounded-full bg-white border-2 border-gray-100 flex items-center justify-center hover:border-[#09543D] hover:bg-[#09543D]/5 transition-all duration-200 shadow-sm hover:shadow-md group"
                aria-label="Dashboard"
              >
                <svg className="w-5 h-5 lg:w-6 lg:h-6 text-gray-600 group-hover:text-[#09543D] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
              </button>

              {/* Order history icon */}
              <button 
                className="w-11 h-11 lg:w-12 lg:h-12 rounded-full bg-white border-2 border-gray-100 flex items-center justify-center hover:border-[#09543D] hover:bg-[#09543D]/5 transition-all duration-200 shadow-sm hover:shadow-md group"
                aria-label="Order History"
              >
                <svg className="w-5 h-5 lg:w-6 lg:h-6 text-gray-600 group-hover:text-[#09543D] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
              </button>

              {/* Logout icon */}
              <button 
                className="w-11 h-11 lg:w-12 lg:h-12 rounded-full bg-white border-2 border-gray-100 flex items-center justify-center hover:border-red-400 hover:bg-red-50 transition-all duration-200 shadow-sm hover:shadow-md group"
                aria-label="Logout"
              >
                <svg className="w-5 h-5 lg:w-6 lg:h-6 text-gray-600 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </header>

      {/* Main Content - Split Layout */}
      <div className="h-screen flex flex-col lg:flex-row pt-16 lg:pt-0 overflow-hidden">
        {/* Left Section - Marketing Content */}
        <div className="hidden lg:flex lg:w-1/2 bg-[#1E4637] p-12 flex-col justify-center">
          <div className="max-w-md">
            <h1 
              className="text-5xl font-bold mb-6 text-white"
              style={{
                fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                letterSpacing: '-1.3px',
                lineHeight: '1.1'
              }}
            >
              Find Your Perfect Coffee
            </h1>
            <p className="text-lg text-white mb-8 leading-relaxed">
              Browse through our curated selection of premium coffee beans. From single origin to custom blends, discover the perfect coffee for your business.
            </p>
            
            {/* Feature Points */}
            <div className="space-y-4 mb-8">
              <div className="flex items-start gap-3">
                <div className="w-6 h-6 rounded-full bg-white flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg className="w-4 h-4 text-[#1E4637]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p className="text-white">Premium quality coffee beans</p>
              </div>
              <div className="flex items-start gap-3">
                <div className="w-6 h-6 rounded-full bg-white flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg className="w-4 h-4 text-[#1E4637]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p className="text-white">Direct from verified farmers</p>
              </div>
              <div className="flex items-start gap-3">
                <div className="w-6 h-6 rounded-full bg-white flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg className="w-4 h-4 text-[#1E4637]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p className="text-white">Competitive wholesale pricing</p>
              </div>
              <div className="flex items-start gap-3">
                <div className="w-6 h-6 rounded-full bg-white flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg className="w-4 h-4 text-[#1E4637]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p className="text-white">Fast and reliable delivery</p>
              </div>
            </div>

            {/* Additional Info */}
            <div className="mt-8 pt-8 border-t border-white/20">
              <p className="text-white/90 text-sm leading-relaxed">
                Join thousands of businesses sourcing premium coffee through ViaNexta's trusted marketplace.
              </p>
            </div>
          </div>
        </div>

        {/* Right Section - Wizard Content */}
        <div className="flex-1 lg:w-1/2 flex flex-col p-8 lg:p-12 bg-white justify-start lg:justify-center items-center overflow-y-auto pt-8 lg:pt-32">
          <div className="w-full max-w-md">
            {/* Question */}
            <div className="text-center mb-6 lg:mb-8">
              <h1 
                className="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-bold text-gray-900 mb-3 leading-tight"
                style={{
                  fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                  letterSpacing: '-1.5px',
                  lineHeight: '1.1'
                }}
              >
                What type of coffee bean
              </h1>
              <h1 
                className="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-bold text-[#09543D] leading-tight"
                style={{
                  fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                  letterSpacing: '-1.5px',
                  lineHeight: '1.1'
                }}
              >
                are you looking for?
              </h1>
            </div>

            {/* Cards */}
            <div className="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-5 max-w-lg mx-auto mb-6">
              {/* Roasted Card */}
              <button
                onClick={() => {
                  setSelectedType('roasted')
                  setTimeout(() => {
                    coffeeTypeSectionRef.current?.scrollIntoView({ behavior: 'smooth', block: 'start' })
                  }, 100)
                }}
                className={`group relative bg-white rounded-xl border-2 p-4 lg:p-5 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${
                  selectedType === 'roasted'
                    ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                    : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-lg'
                }`}
              >
                {/* Selection indicator */}
                {selectedType === 'roasted' && (
                  <div className="absolute top-2 right-2 w-4 h-4 bg-[#09543D] rounded-full flex items-center justify-center">
                    <svg className="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3} d="M5 13l4 4L19 7" />
                    </svg>
                  </div>
                )}
                
                <div className="flex justify-center mb-3 lg:mb-4">
                  <img src={roastedIcon} alt="Roasted" className="w-16 h-16 lg:w-20 lg:h-20 object-contain transition-transform duration-300 group-hover:scale-110" />
                </div>
                <h3 
                  className={`text-base lg:text-lg font-bold transition-colors ${
                    selectedType === 'roasted' ? 'text-[#09543D]' : 'text-gray-800'
                  }`}
                  style={{
                    fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                    letterSpacing: '-0.5px'
                  }}
                >
                  Roasted
                </h3>
              </button>

              {/* Wholesale Brands Card */}
              <button
                onClick={() => setSelectedType('wholesale')}
                className={`group relative bg-white rounded-xl border-2 p-4 lg:p-5 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${
                  selectedType === 'wholesale'
                    ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                    : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-lg'
                }`}
              >
                {/* Selection indicator */}
                {selectedType === 'wholesale' && (
                  <div className="absolute top-2 right-2 w-4 h-4 bg-[#09543D] rounded-full flex items-center justify-center">
                    <svg className="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3} d="M5 13l4 4L19 7" />
                    </svg>
                  </div>
                )}
                
                <div className="flex justify-center mb-3 lg:mb-4">
                  <img src={wholesaleBrandsIcon} alt="Wholesale Brands" className="w-16 h-16 lg:w-20 lg:h-20 object-contain transition-transform duration-300 group-hover:scale-110" />
                </div>
                <h3 
                  className={`text-base lg:text-lg font-bold transition-colors ${
                    selectedType === 'wholesale' ? 'text-[#09543D]' : 'text-gray-800'
                  }`}
                  style={{
                    fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                    letterSpacing: '-0.5px'
                  }}
                >
                  Wholesale Brands
                </h3>
              </button>
            </div>

            {/* Second Question - How do you want your coffee? */}
            {selectedType === 'roasted' && (
              <div 
                ref={coffeeTypeSectionRef} 
                className={`mt-8 lg:mt-10 transition-all duration-500 ${
                  showCoffeeType ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'
                }`}
              >
                <h2 
                  className="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 text-center mb-6 lg:mb-8"
                  style={{
                    fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                    letterSpacing: '-1.5px',
                    lineHeight: '1.1'
                  }}
                >
                  How do you want your coffee?
                </h2>

                {/* Cards */}
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-5 max-w-lg mx-auto">
                  {/* Single Origin Card */}
                  <button
                    onClick={() => {
                      setSelectedCoffeeType('single-origin')
                      setTimeout(() => {
                        singleOriginSectionRef.current?.scrollIntoView({ behavior: 'smooth', block: 'start' })
                      }, 100)
                    }}
                    className={`group relative bg-white rounded-xl border-2 p-4 lg:p-5 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${
                      selectedCoffeeType === 'single-origin'
                        ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                        : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-lg'
                    }`}
                  >
                    {/* Selection indicator */}
                    {selectedCoffeeType === 'single-origin' && (
                      <div className="absolute top-2 right-2 w-4 h-4 bg-[#09543D] rounded-full flex items-center justify-center">
                        <svg className="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3} d="M5 13l4 4L19 7" />
                        </svg>
                      </div>
                    )}
                    
                    <div className="flex justify-center mb-3 lg:mb-4">
                      <img src={singleOriginIcon} alt="Single Origin" className="w-16 h-16 lg:w-20 lg:h-20 object-contain transition-transform duration-300 group-hover:scale-110" />
                    </div>
                    <h3 
                      className={`text-base lg:text-lg font-bold transition-colors ${
                        selectedCoffeeType === 'single-origin' ? 'text-[#09543D]' : 'text-gray-800'
                      }`}
                      style={{
                        fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                        letterSpacing: '-0.5px'
                      }}
                    >
                      Single Origin
                    </h3>
                  </button>

                  {/* Blend Card */}
                  <button
                    onClick={() => setSelectedCoffeeType('blend')}
                    className={`group relative bg-white rounded-xl border-2 p-4 lg:p-5 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${
                      selectedCoffeeType === 'blend'
                        ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                        : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-lg'
                    }`}
                  >
                    {/* Selection indicator */}
                    {selectedCoffeeType === 'blend' && (
                      <div className="absolute top-2 right-2 w-4 h-4 bg-[#09543D] rounded-full flex items-center justify-center">
                        <svg className="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3} d="M5 13l4 4L19 7" />
                        </svg>
                      </div>
                    )}
                    
                    <div className="flex justify-center mb-3 lg:mb-4">
                      <img src={blendIcon} alt="Blend" className="w-16 h-16 lg:w-20 lg:h-20 object-contain transition-transform duration-300 group-hover:scale-110" />
                    </div>
                    <h3 
                      className={`text-base lg:text-lg font-bold transition-colors ${
                        selectedCoffeeType === 'blend' ? 'text-[#09543D]' : 'text-gray-800'
                      }`}
                      style={{
                        fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                        letterSpacing: '-0.5px'
                      }}
                    >
                      Blend
                    </h3>
                  </button>
                </div>
              </div>
            )}

            {/* Single Origin View */}
            {selectedCoffeeType === 'single-origin' && (
              <div 
                ref={singleOriginSectionRef} 
                className={`mt-8 lg:mt-10 transition-all duration-500 ${
                  showSingleOrigin ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'
                }`}
              >
                {/* Heading */}
                <h2 
                  className="text-xl lg:text-2xl font-bold text-gray-900 text-center mb-6 lg:mb-8"
                  style={{
                    fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                    letterSpacing: '-1px'
                  }}
                >
                  Single origin
                </h2>

                {/* Coffee Cards Grid */}
                <div className="grid grid-cols-2 gap-3 lg:gap-4 mb-6">
                  {/* Sample coffee cards */}
                  {[
                    { name: 'ETHIOPIA GUJI', country: 'Ethiopia', score: 88 },
                    { name: 'KENYA AB', country: 'Kenya', score: 90 },
                    { name: 'TANZANIA ZANZIBAR', country: 'Tanzania', score: 96 },
                    { name: 'PERU', country: 'Peru', score: 93 },
                    { name: 'KENYA AA', country: 'Kenya', score: 89 },
                    { name: 'ETHIOPIA', country: 'Ethiopia', score: 91 },
                    { name: 'TANZANIA PEABERRY', country: 'Tanzania', score: 93 },
                    { name: 'UGANDA BUGISHU', country: 'Uganda', score: 86 },
                  ].map((coffee, index) => (
                    <div
                      key={index}
                      className="bg-white rounded-xl border-2 border-gray-200 p-3 hover:border-[#09543D] hover:shadow-lg transition-all cursor-pointer"
                    >
                      {/* Coffee Bean Image */}
                      <div className="w-full h-20 bg-gray-100 rounded-lg mb-2 flex items-center justify-center">
                        <div className="w-12 h-12 bg-gradient-to-br from-green-700 to-green-900 rounded-lg"></div>
                      </div>

                      {/* Coffee Name */}
                      <h3 
                        className="text-xs font-bold text-gray-900 mb-2 uppercase truncate"
                        style={{
                          fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                        }}
                      >
                        {coffee.name}
                      </h3>

                      {/* Bottom Section */}
                      <div className="flex items-center justify-between">
                        {/* Left: Flag and Country */}
                        <div className="flex items-center gap-1.5">
                          <div className="w-3 h-3 bg-green-500 rounded-sm"></div>
                          <span className="text-[10px] text-gray-600 truncate">{coffee.country}</span>
                        </div>

                        {/* Right: Score */}
                        <div className="bg-[#D8501C] text-white px-1.5 py-0.5 rounded text-[10px] font-bold">
                          {coffee.score}
                        </div>
                      </div>
                    </div>
                  ))}
                </div>

                {/* Pagination */}
                <div className="flex flex-col items-center gap-4">
                  {/* Page indicator */}
                  <p 
                    className="text-sm text-gray-600"
                    style={{
                      fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                    }}
                  >
                    Page {currentPage} of {totalPages}
                  </p>

                  {/* Page number buttons */}
                  <div className="flex gap-2">
                    {[1, 2].map((page) => (
                      <button
                        key={page}
                        onClick={() => setCurrentPage(page)}
                        className={`w-10 h-10 rounded-lg font-bold transition-all ${
                          currentPage === page
                            ? 'bg-[#D8501C] text-white shadow-md'
                            : 'bg-white border border-gray-200 text-gray-700 hover:border-gray-300'
                        }`}
                        style={{
                          fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                        }}
                      >
                        {page}
                      </button>
                    ))}
                  </div>

                  {/* Navigation buttons */}
                  <div className="flex gap-4">
                    <button
                      onClick={() => setCurrentPage(prev => Math.max(1, prev - 1))}
                      disabled={currentPage === 1}
                      className={`px-6 py-2.5 rounded-xl border font-semibold transition-all flex items-center gap-2 ${
                        currentPage === 1
                          ? 'bg-gray-100 border-gray-200 text-gray-400 cursor-not-allowed'
                          : 'bg-white border-gray-200 text-gray-700 hover:border-gray-300 hover:bg-gray-50'
                      }`}
                      style={{
                        fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                      }}
                    >
                      <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
                      </svg>
                      Previous
                    </button>
                    <button
                      onClick={() => setCurrentPage(prev => Math.min(totalPages, prev + 1))}
                      disabled={currentPage === totalPages}
                      className={`px-6 py-2.5 rounded-xl border font-semibold transition-all flex items-center gap-2 ${
                        currentPage === totalPages
                          ? 'bg-gray-100 border-gray-200 text-gray-400 cursor-not-allowed'
                          : 'bg-white border-[#09543D] text-[#09543D] hover:bg-[#09543D]/5 hover:border-[#09543D]/80'
                      }`}
                      style={{
                        fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                      }}
                    >
                      Next
                      <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
            )}
          </div>
        </div>
      </div>

      {/* Chat Button */}
      <ChatButton />
    </div>
  )
}

export default BuyerWizard

import { useEffect, useState } from 'react'
const chainBuilderBg = '/assets/chain-builder.svg'


interface ChainBuilderProps {
  isBuyMode: boolean
}

function ChainBuilder({ isBuyMode }: ChainBuilderProps) {
  const [selectedCategory, setSelectedCategory] = useState<string>(isBuyMode ? 'Business Type' : 'Coffee')
  const [backgroundPosition, setBackgroundPosition] = useState('top center')
  const [backgroundSize, setBackgroundSize] = useState('110% auto')
  const [showSvgBackground, setShowSvgBackground] = useState(false)

  useEffect(() => {
    // Reset selected category when tab changes
    setSelectedCategory(isBuyMode ? 'Business Type' : 'Coffee')
  }, [isBuyMode])

  useEffect(() => {
    // Handle background positioning for very wide screens
    const updateBackground = () => {
      const width = window.innerWidth
      // Hide SVG background at 1280px and below
      setShowSvgBackground(width > 1280)

      if (width > 1920) {
        // For very wide screens, ensure background covers the full 110vw section width
        // Account for scale(1.5) transform - need larger size to ensure full coverage
        // Using 150vw to ensure it covers 110vw section even with scaling
        setBackgroundPosition('top center')
        setBackgroundSize('150vw auto')
      } else {
        setBackgroundPosition('top center')
        setBackgroundSize('110% auto')
      }
    }

    updateBackground()
    window.addEventListener('resize', updateBackground)

    return () => {
      window.removeEventListener('resize', updateBackground)
    }
  }, [])



  return (
    <section id="chain-builder"
      className="relative overflow-visible"
      style={{
        minHeight: '100vh',
        width: '110vw',
        position: 'relative',
        left: '50%',
        marginLeft: '-55vw',
        marginRight: '-55vw',
        marginTop: '-10vh',
        zIndex: 10,
        backgroundColor: isBuyMode ? '#09543D' : '#F9F7F1'
      }}
    >
      {/* Background SVG - overlapping FromIdeaToInventory with wavy edge - Hidden at 1280px and below */}
      <div
        className="absolute"
        style={{
          display: showSvgBackground ? 'block' : 'none',
          top: 0,
          bottom: 0,
          left: 0,
          right: 0,
          width: '100%',
          height: '100%',
          backgroundImage: isBuyMode ? 'none' : `url(${chainBuilderBg})`,
          backgroundColor: isBuyMode ? '#09543D' : 'transparent',
          backgroundSize: backgroundSize,
          backgroundPosition: backgroundPosition,
          backgroundRepeat: 'no-repeat',
          transform: 'translateY(-15%) scale(1.5)',
          zIndex: 0,
          WebkitMaskImage: isBuyMode ? `url(${chainBuilderBg})` : 'none',
          maskImage: isBuyMode ? `url(${chainBuilderBg})` : 'none',
          WebkitMaskSize: isBuyMode ? backgroundSize : 'auto',
          maskSize: isBuyMode ? backgroundSize : 'auto',
          WebkitMaskPosition: isBuyMode ? backgroundPosition : 'auto',
          maskPosition: isBuyMode ? backgroundPosition : 'auto',
          WebkitMaskRepeat: isBuyMode ? 'no-repeat' : 'auto',
          maskRepeat: isBuyMode ? 'no-repeat' : 'auto'
        }}
      />

      {/* Content */}
      <div className="relative z-10 container mx-auto px-4">
        <div className="pt-12 md:pt-16 pb-20 flex flex-col items-center justify-center">
          <div className="text-center max-w-4xl">
            {/* Main Heading */}
            <h2
              className="font-bold overflow-hidden mb-6"
              style={{
                fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                letterSpacing: '-1.3px',
                lineHeight: '0.9',
                color: isBuyMode ? '#FEFEFF' : '#09543D'
              }}
            >
              <span className="block text-4xl md:text-5xl lg:text-6xl overflow-hidden">TRY OUR</span>
              <span className="block text-5xl md:text-6xl lg:text-7xl xl:text-8xl overflow-hidden">CHAIN BUILDER</span>
            </h2>

            {/* Description */}
            <p
              className={`text-lg md:text-xl text-center overflow-hidden mb-12 ${isBuyMode ? 'text-[#FEFEFF]' : 'text-[#09543D]'}`}
            >
              Pick a product category and watch the AI assemble a recommended supply chain structure.
            </p>
          </div>

          {/* Cards Section */}
          <div className="w-full max-w-7xl mx-auto mt-12 flex flex-col lg:flex-row gap-6 px-4">
            {/* Left Card - Input Panel */}
            <div className="lg:w-1/2 bg-white rounded-2xl p-6 md:p-8 shadow-lg">
              {/* SELECT CATEGORY Title */}
              <h3 className="text-gray-700 uppercase text-sm font-semibold mb-4">
                SELECT CATEGORY
              </h3>

              {/* Category Buttons */}
              {isBuyMode ? (
                <div className="grid grid-cols-3 gap-3 mb-3">
                  <button
                    onClick={() => setSelectedCategory('Business Type')}
                    className={`px-4 py-3 rounded-lg border-2 transition-all ${selectedCategory === 'Business Type'
                      ? 'border-[#09543D] bg-[#09543D]/5'
                      : 'border-gray-300 bg-white hover:border-gray-400'
                      }`}
                  >
                    <span className="text-gray-700 font-medium">Business Type</span>
                  </button>
                  <button
                    onClick={() => setSelectedCategory('Product Type')}
                    className={`px-4 py-3 rounded-lg border-2 transition-all ${selectedCategory === 'Product Type'
                      ? 'border-[#09543D] bg-[#09543D]/5'
                      : 'border-gray-300 bg-white hover:border-gray-400'
                      }`}
                  >
                    <span className="text-gray-700 font-medium">Product Type</span>
                  </button>
                  <button
                    onClick={() => setSelectedCategory('Quality Range')}
                    className={`px-4 py-3 rounded-lg border-2 transition-all ${selectedCategory === 'Quality Range'
                      ? 'border-[#09543D] bg-[#09543D]/5'
                      : 'border-gray-300 bg-white hover:border-gray-400'
                      }`}
                  >
                    <span className="text-gray-700 font-medium">Quality Range</span>
                  </button>
                </div>
              ) : (
                <div className="grid grid-cols-2 gap-3 mb-6">
                  <button
                    onClick={() => setSelectedCategory('Coffee')}
                    className={`px-4 py-3 rounded-lg border-2 transition-all ${selectedCategory === 'Coffee'
                      ? 'border-[#09543D] bg-[#09543D]/5'
                      : 'border-gray-300 bg-white hover:border-gray-400'
                      }`}
                  >
                    <span className="text-gray-700 font-medium">Coffee</span> ☕
                  </button>
                  <button
                    onClick={() => setSelectedCategory('Skincare')}
                    className={`px-4 py-3 rounded-lg border-2 transition-all ${selectedCategory === 'Skincare'
                      ? 'border-[#09543D] bg-[#09543D]/5'
                      : 'border-gray-300 bg-white hover:border-gray-400'
                      }`}
                  >
                    <span className="text-gray-700 font-medium">Skincare</span> 🧴
                  </button>
                  <button
                    onClick={() => setSelectedCategory('Juice')}
                    className={`px-4 py-3 rounded-lg border-2 transition-all ${selectedCategory === 'Juice'
                      ? 'border-[#09543D] bg-[#09543D]/5'
                      : 'border-gray-300 bg-white hover:border-gray-400'
                      }`}
                  >
                    <span className="text-gray-700 font-medium">Juice</span> 🍊
                  </button>
                </div>
              )}
              {isBuyMode && (
                <div className="mb-6">
                  <button
                    onClick={() => setSelectedCategory('Delivery location')}
                    className={`w-full px-4 py-3 rounded-lg border-2 transition-all ${selectedCategory === 'Delivery location'
                      ? 'border-[#09543D] bg-[#09543D]/5'
                      : 'border-gray-300 bg-white hover:border-gray-400'
                      }`}
                  >
                    <span className="text-gray-700 font-medium">Delivery location</span>
                  </button>
                </div>
              )}

              {/* Input Field */}
              <div className="mb-6">
                <textarea
                  placeholder="Enter your CGP and your idea..."
                  className="w-full h-32 p-4 bg-gray-100 rounded-lg border-none resize-none focus:outline-none focus:ring-2 focus:ring-[#09543D] text-gray-700 placeholder-gray-400"
                />
              </div>

              {/* Progress Section */}
              <div className="mb-6">
                <p className="text-gray-700 text-sm mb-2">Clare is analyzing your data...</p>
                <div className="flex items-center gap-3">
                  <div className="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                    <div
                      className="h-full bg-[#B8F03F] rounded-full transition-all duration-300"
                      style={{ width: '24%' }}
                    />
                  </div>
                  <span className="text-gray-700 text-sm font-medium">24%</span>
                </div>
              </div>

              {/* View Result Button */}
              <button className="w-full bg-[#09543D] text-white py-3 px-6 rounded-full font-semibold hover:bg-[#09543D]/90 transition-colors">
                View Result
              </button>
            </div>

            {/* Right Card - Image Placeholder */}
            <div className="lg:w-1/2 bg-gray-200 rounded-2xl shadow-lg flex items-center justify-center min-h-[500px]">
              <div className="text-gray-400 text-center">
                <svg
                  className="w-24 h-24 mx-auto mb-4"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth={2}
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                  />
                </svg>
                <p className="text-sm">Image Placeholder</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  )
}

export default ChainBuilder


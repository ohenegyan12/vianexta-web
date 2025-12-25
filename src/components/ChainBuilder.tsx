import { useEffect, useState, useRef } from 'react'
const chainBuilderBg = '/assets/chain-builder.svg'


interface ChainBuilderProps {
  isBuyMode: boolean
}

function ChainBuilder({ isBuyMode }: ChainBuilderProps) {
  const [selectedCategory, setSelectedCategory] = useState<string>(isBuyMode ? 'Business Type' : 'Coffee')
  const [backgroundPosition, setBackgroundPosition] = useState('top center')
  const [backgroundSize, setBackgroundSize] = useState('110% auto')
  const [showSvgBackground, setShowSvgBackground] = useState(false)

  // Interactive Demo State
  // Step Definitions matching design
  const steps = [
    {
      id: 'sourcing',
      label: 'Sourcing',
      title: 'Find the best ingredients',
      description: 'Connecting with suppliers who meet your quality standards',
      icon: <img src="/assets/sourcing.gif" alt="Sourcing" className="w-full h-full object-contain" />
    },
    {
      id: 'processing',
      label: 'Processing',
      title: 'Transform raw materials',
      description: 'Refining your ingredients into a finished product',
      icon: <img src="/assets/processing.gif" alt="Processing" className="w-full h-full object-contain" />
    },
    {
      id: 'packaging',
      label: 'Packaging',
      title: 'Designing your product’s look',
      description: 'Creating a package that reflects your brand’s identity',
      icon: <img src="/assets/packaging.gif" alt="Packaging" className="w-full h-full object-contain" />
    },
    {
      id: 'branding',
      label: 'Branding',
      title: 'Crafting your brand’s story',
      description: 'Develop a unique brand identity that resonates with customers',
      icon: <img src="/assets/branding.gif" alt="Branding" className="w-full h-full object-contain" />
    },
    {
      id: 'warehousing',
      label: 'Warehousing',
      title: 'Storing your products securely',
      description: 'Keeping your inventory safe and organized for efficient distribution.',
      icon: <img src="/assets/warehousing.gif" alt="Warehousing" className="w-full h-full object-contain" />
    },
    {
      id: 'shipping',
      label: 'Shipping',
      title: 'Delivering to your customers',
      description: 'Getting your products to customers',
      icon: <img src="/assets/shipping.gif" alt="Shipping" className="w-full h-full object-contain" />
    },
    {
      id: 'success',
      label: 'Success',
      title: 'Success!',
      description: 'Your supply chain is ready.',
      icon: <img src="/assets/success.gif" alt="Success" className="w-full h-full object-contain" />
    }
  ]

  const [processing, setProcessing] = useState(false)
  const [currentStep, setCurrentStep] = useState(0)
  const [progress, setProgress] = useState(0)
  const stepRefs = useRef<(HTMLDivElement | null)[]>([])

  useEffect(() => {
    // Auto-scroll logic removed to allow CSS transitions to handle the "move out of frame" effect naturally
  }, [currentStep, processing])

  const handleViewResult = () => {
    setProcessing(true)
    setCurrentStep(0)
    setProgress(0)

    // Total steps = length - 1 (indices)
    const totalSteps = steps.length - 1
    let step = 0

    const interval = setInterval(() => {
      step++
      if (step <= totalSteps) {
        setCurrentStep(step)
        // Update progress bar
        setProgress(Math.round((step / totalSteps) * 100))
      } else {
        clearInterval(interval)
      }
    }, 2400) // 2.4s per step
  }

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
      {/* Background SVG */}
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
            <div className="lg:w-1/2 bg-white rounded-2xl p-6 md:p-8 shadow-lg h-[550px] flex flex-col">
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
              <div className="mb-6 flex-1">
                <textarea
                  placeholder="Enter your CGP and your idea..."
                  className="w-full h-full p-4 bg-gray-100 rounded-lg border-none resize-none focus:outline-none focus:ring-2 focus:ring-[#09543D] text-gray-700 placeholder-gray-400"
                />
              </div>

              {/* Progress Section */}
              <div className="mb-6">
                <p className="text-gray-700 text-sm mb-2">Clare is analyzing your data...</p>
                <div className="flex items-center gap-3">
                  <div className="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                    <div
                      className="h-full bg-[#B8F03F] rounded-full transition-all duration-300"
                      style={{ width: `${progress}%` }}
                    />
                  </div>
                  <span className="text-gray-700 text-sm font-medium">{progress}%</span>
                </div>
              </div>

              {/* View Result Button */}
              <button
                onClick={handleViewResult}
                disabled={processing}
                className={`w-full bg-[#09543D] text-white py-3 px-6 rounded-full font-semibold transition-colors ${processing ? 'opacity-70 cursor-not-allowed' : 'hover:bg-[#09543D]/90'
                  }`}
              >
                {processing ? 'Creating Chain...' : 'Create'}
              </button>
            </div>

            {/* Right Card - Steps Visualization */}
            {processing || currentStep > 0 ? (
              <div className="lg:w-1/2 bg-white rounded-2xl shadow-lg flex flex-col h-[550px] border border-gray-100 overflow-hidden relative">
                <div className="relative w-full h-full flex-1 overflow-y-auto px-8 py-8 custom-scrollbar">
                  <div className="flex flex-col h-full">
                    {steps.map((step, index) => {
                      const isActive = index === currentStep
                      const isPast = index < currentStep

                      // Special rendering for Success step
                      if (step.id === 'success') {
                        return (
                          <div
                            key={step.id}
                            ref={el => stepRefs.current[index] = el}
                            className={`transition-all duration-700 ease-in-out overflow-hidden ${isActive
                              ? 'opacity-100 scale-100 h-full max-h-full flex flex-col items-center justify-center'
                              : 'opacity-40 scale-95 py-4 mb-6 max-h-[200px]'
                              } ${isPast ? '!max-h-0 !py-0 !mb-0 opacity-0' : ''}`}
                          >
                            {isActive ? (
                              <div className="flex flex-col items-center justify-center text-center h-full w-full">
                                <div className="flex flex-col items-center justify-center">
                                  {/* Success Checkmark Animation */}
                                  <div className="w-48 h-48 mb-6 relative">
                                    {step.icon}
                                  </div>
                                  <h3 className="text-[#09543D] text-3xl font-bold mb-2">Success!</h3>
                                  <p className="text-gray-600 mb-8">Your supply chain is ready.</p>
                                  <button className="bg-[#09543D] text-white px-8 py-3 rounded-full font-bold hover:bg-[#09543D]/90 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    View Product
                                  </button>
                                </div>
                              </div>
                            ) : (
                              <div className="py-1">
                                <h4 className="text-gray-400 font-medium text-sm mb-1">Finish</h4>
                                <h3 className="text-gray-300 text-lg font-bold">Success</h3>
                              </div>
                            )}
                          </div>
                        )
                      }

                      // Standard Step Rendering
                      return (
                        <div
                          key={step.id}
                          ref={el => stepRefs.current[index] = el}
                          className={`transition-all duration-700 ease-in-out ${isActive
                            ? 'opacity-100 scale-100 mb-6' // Removed overflow-hidden and max-h limit for active to prevent cutoff
                            : 'opacity-40 scale-95 mb-6 overflow-hidden max-h-[200px]' // Keep constrain for inactive future steps
                            } ${isPast ? '!max-h-0 !py-0 !mb-0 opacity-0 overflow-hidden' : ''}`} // Past steps still collapse
                        >
                          {/* Active State */}
                          {isActive && (
                            <div className="space-y-3">
                              <div className="w-16 h-16 flex items-center justify-center mb-4">
                                {step.icon}
                              </div>
                              <div>
                                <h4 className="text-[#09543D] font-bold text-lg mb-1">{step.label}</h4>
                                <h3 className="text-[#09543D] text-3xl font-bold leading-tight mb-2">{step.title}</h3>
                                <p className="text-gray-600 text-base leading-relaxed">{step.description}</p>
                              </div>
                            </div>
                          )}

                          {/* Inactive State (Future) */}
                          {!isActive && !isPast && (
                            <div className="py-1">
                              <h4 className="text-gray-400 font-medium text-sm mb-1">{step.label}</h4>
                              <h3 className="text-gray-300 text-lg font-bold">{step.title}</h3>
                            </div>
                          )}
                        </div>
                      )
                    })}
                  </div>
                </div>
              </div>
            ) : (
              <div className="lg:w-1/2 bg-white rounded-2xl shadow-lg flex items-center justify-center h-[550px]">
                <div className="text-gray-400 text-center px-8">
                  <p className="text-lg font-medium text-gray-500">
                    Select a product and enter your idea to get started
                  </p>
                </div>
              </div>
            )}
          </div>
        </div>
      </div>
    </section>
  )
}

export default ChainBuilder

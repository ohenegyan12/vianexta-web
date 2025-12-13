import { useEffect, useRef, useState } from 'react'
import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'


gsap.registerPlugin(ScrollTrigger)
const fromIdeaBg = '/assets/from-idea.svg'
import sourcingIcon from '../../assets/sourcing.svg'
import brandingIcon from '../../assets/branding.svg'
import packagingIcon from '../../assets/packaging.svg'
import shippingIcon from '../../assets/shipping.svg'

import cacaoImg from '../../assets/cacao.jpg'
import cashewImg from '../../assets/cashew.jpg'
import mangoImg from '../../assets/mango.jpg'
import templateImg from '../../assets/TEMPLATE-01.jpg'

interface FromIdeaToInventoryProps {
  isBuyMode: boolean
}

function FromIdeaToInventory({ isBuyMode }: FromIdeaToInventoryProps) {

  const sourcingCardRef = useRef<HTMLDivElement>(null)
  const brandingCardRef = useRef<HTMLDivElement>(null)
  const packagingCardRef = useRef<HTMLDivElement>(null)
  const shippingCardRef = useRef<HTMLDivElement>(null)
  const [backgroundSize, setBackgroundSize] = useState('120% 100%')
  const [backgroundPosition, setBackgroundPosition] = useState('top center')
  const [isMobile, setIsMobile] = useState(false)

  // Progress bar states
  const [activeIndex, setActiveIndex] = useState(0)
  const [progressValues, setProgressValues] = useState([0, 0, 0, 0])

  useEffect(() => {
    // Handle responsive background size and position
    const updateBackground = () => {
      const width = window.innerWidth
      const mobile = width <= 1280  // Hide SVGs at 1280px and below
      setIsMobile(mobile)
      if (mobile) {
        setBackgroundSize('70% 80%')
        setBackgroundPosition('center top')
      } else if (width > 1920) {
        // For very wide screens, ensure background covers the full 110vw section width
        // Use a larger size to ensure no gaps on the sides
        setBackgroundSize('120vw 100%')
        setBackgroundPosition('center top')
      } else {
        setBackgroundSize('120% 100%')
        setBackgroundPosition('top center')
      }
    }

    updateBackground()
    window.addEventListener('resize', updateBackground)

    return () => {
      window.removeEventListener('resize', updateBackground)
    }
  }, [])

  // Sequential progress bar animation
  useEffect(() => {
    let animationFrameId: number | null = null
    let startTime: number | null = null
    let currentActiveIndex = 0
    const duration = 6000 // 6 seconds per progress bar

    const animate = (timestamp: number) => {
      if (!startTime) startTime = timestamp
      const elapsed = timestamp - startTime
      const progress = Math.min(elapsed / duration, 1)

      setProgressValues(prev => {
        const newValues = [...prev]
        newValues[currentActiveIndex] = progress * 100
        // Reset others to 0
        for (let i = 0; i < 4; i++) {
          if (i !== currentActiveIndex) newValues[i] = 0
        }
        return newValues
      })

      if (progress < 1) {
        animationFrameId = requestAnimationFrame(animate)
      } else {
        // Move to next
        currentActiveIndex = (currentActiveIndex + 1) % 4
        setActiveIndex(currentActiveIndex)
        startTime = null
        animationFrameId = requestAnimationFrame(animate)
      }
    }

    // Start animation immediately
    animationFrameId = requestAnimationFrame(animate)

    return () => {
      if (animationFrameId) {
        cancelAnimationFrame(animationFrameId)
      }
    }
  }, [])

  // Image array corresponding to the 4 sections
  const featureImages = [cacaoImg, cashewImg, mangoImg, templateImg]









  useEffect(() => {
    const cards = [
      sourcingCardRef.current,
      brandingCardRef.current,
      packagingCardRef.current,
      shippingCardRef.current
    ].filter(Boolean) as HTMLDivElement[]

    if (cards.length === 0) return

    // Set initial z-index and rotation (only on desktop) - no scroll animations
    const isDesktop = window.innerWidth >= 768
    const rotations = [3.7, -2.89, 3.7, -2.89]

    cards.forEach((card, index) => {
      gsap.set(card, {
        zIndex: cards.length - index,
        rotation: isDesktop ? rotations[index] : 0,
        transformOrigin: 'center center'
      })
    })
  }, [])

  return (
    <section
      id="how-it-works"
      className="relative overflow-hidden"
      style={{
        minHeight: isMobile ? 'auto' : '150vh',
        width: '110vw',
        position: 'relative',
        left: '50%',
        marginLeft: '-55vw',
        marginRight: '-55vw',
        backgroundColor: 'transparent'
      }}
    >
      {/* Background color layer - starts below the top shape to make it visible (or full coverage below 1024px) */}
      <div
        className="absolute"
        style={{
          top: isBuyMode ? 0 : (isMobile ? 0 : '25%'),
          bottom: 0,
          left: 0,
          right: 0,
          width: '100%',
          height: '100%',
          backgroundColor: isBuyMode ? (isMobile ? '#F8F7F1' : '#09543D') : '#09543D',
          zIndex: 0
        }}
      />

      {/* Background SVG - Hidden at 1280px and below */}
      <div
        className="absolute"
        style={{
          display: isMobile ? 'none' : 'block',
          top: 0,
          bottom: 0,
          left: 0,
          right: 0,
          width: '100%',
          height: '100%',
          backgroundImage: isBuyMode ? 'none' : `url(${fromIdeaBg})`,
          backgroundColor: isBuyMode ? '#F8F7F1' : 'transparent',
          backgroundSize: backgroundSize,
          backgroundPosition: backgroundPosition,
          backgroundRepeat: 'no-repeat',
          pointerEvents: 'none',
          zIndex: 1,
          WebkitMaskImage: isBuyMode ? `url(${fromIdeaBg})` : 'none',
          maskImage: isBuyMode ? `url(${fromIdeaBg})` : 'none',
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
        {/* Title Section */}
        <div className={`pb-20 flex flex-col items-center ${isMobile ? 'pt-12 justify-start' : 'pt-32 justify-center'}`} style={{ minHeight: isMobile ? 'auto' : '100vh' }}>
          <div className={`text-center max-w-4xl ${isMobile ? 'mt-8' : ''}`}>
            {/* Main Heading */}
            <h2
              key={isBuyMode ? 'buy' : 'build'}
              className="text-6xl md:text-7xl lg:text-8xl font-bold mb-8 text-white overflow-hidden"
              style={{
                fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                letterSpacing: '-1.3px',
                lineHeight: '0.9'
              }}
            >
              {isBuyMode ? (
                <>
                  <span style={{ color: '#09543D' }}>FROM</span>{' '}
                  <span className="relative inline-block px-2" style={{ backgroundColor: '#B8F03F', color: '#2D544E' }}>
                    SELECTION
                  </span>
                  {' '}<span style={{ color: '#09543D' }}>TO</span>{' '}
                  <span style={{ color: '#09543D' }}>DELIVERY</span>
                </>
              ) : (
                <>
                  FROM{' '}
                  <span className="relative inline-block px-2" style={{ backgroundColor: '#B8F03F', color: '#2D544E' }}>
                    IDEA
                  </span>
                  {' '}TO{' '}
                  <span>INVENTORY</span>
                </>
              )}
            </h2>

            {/* Description */}
            <div className={`px-6 py-4 rounded-lg inline-block mb-2 ${isBuyMode ? 'bg-transparent' : 'bg-[#09543D]'}`}>
              <p
                key={isBuyMode ? 'buy-desc' : 'build-desc'}
                className={`text-lg md:text-xl text-center overflow-hidden ${isBuyMode ? 'text-[#09543D]' : 'text-white'}`}
              >
                {isBuyMode ? (
                  "We help cafés, retailers, offices, and hospitality businesses source trusted products — consistently, transparently, and at scale."
                ) : (
                  <>
                    We guide you through sourcing, branding, packaging and shipping, with recommendations from{' '}
                    <span className="text-[#B8F03F]">"clare"</span>
                    {' '}at every step.
                  </>
                )}
              </p>
            </div>
          </div>
        </div>

        {/* Steps Section */}
        <div className="pb-48 md:pb-32 space-y-3 md:space-y-6 max-w-4xl mx-auto mt-8 md:-mt-16 px-4 md:px-0">
          {/* Step 1: Sourcing */}
          <div
            ref={sourcingCardRef}
            className="bg-white rounded-xl md:rounded-2xl p-4 md:p-8 md:shadow-lg flex flex-row items-start gap-3 md:gap-6"
          >
            <div className="flex-1">
              <h3 className="text-xl md:text-3xl font-bold mb-1 md:mb-3" style={{ color: '#09543D' }}>
                {isBuyMode ? 'Product Selection' : 'Sourcing'}
              </h3>
              <p className="text-gray-700 text-xs md:text-base lg:text-lg leading-tight md:leading-normal">
                {isBuyMode
                  ? 'Choose from a curated range of ready-to-sell, high-quality products across multiple categories.'
                  : 'Access a vetted network of suppliers. Filter by sustainability, location, and price instantly.'}
              </p>
            </div>
            <div className="flex-shrink-0">
              <img src={sourcingIcon} alt={isBuyMode ? 'Product Selection' : 'Sourcing'} className="w-12 h-12 md:w-24 md:h-24" />
            </div>
          </div>

          {/* Step 2: Branding */}
          <div
            ref={brandingCardRef}
            className="bg-white rounded-xl md:rounded-2xl p-4 md:p-8 md:shadow-lg flex flex-row items-start gap-3 md:gap-6"
          >
            <div className="flex-1">
              <h3 className="text-xl md:text-3xl font-bold mb-1 md:mb-3" style={{ color: '#09543D' }}>
                {isBuyMode ? 'Wholesale Pricing' : 'Branding'}
              </h3>
              <p className="text-gray-700 text-xs md:text-base lg:text-lg leading-tight md:leading-normal">
                {isBuyMode
                  ? 'Access fair, transparent wholesale pricing with no hidden markups.'
                  : 'Clare helps generate logos, color palettes, and brand stories that resonate with your niche.'}
              </p>
            </div>
            <div className="flex-shrink-0">
              <img src={brandingIcon} alt={isBuyMode ? 'Wholesale Pricing' : 'Branding'} className="w-12 h-12 md:w-24 md:h-24" />
            </div>
          </div>

          {/* Step 3: Packaging */}
          <div
            ref={packagingCardRef}
            className="bg-white rounded-xl md:rounded-2xl p-4 md:p-8 md:shadow-lg flex flex-row items-start gap-3 md:gap-6"
          >
            <div className="flex-1">
              <h3 className="text-xl md:text-3xl font-bold mb-1 md:mb-3" style={{ color: '#09543D' }}>
                {isBuyMode ? 'Optional White-Label' : 'Packaging'}
              </h3>
              <p className="text-gray-700 text-xs md:text-base lg:text-lg leading-tight md:leading-normal">
                {isBuyMode
                  ? 'Add your logo or custom packaging where available — no full brand build required.'
                  : 'Visualize 3D mockups of your product. Select materials and get print-ready files automatically.'}
              </p>
            </div>
            <div className="flex-shrink-0">
              <img src={packagingIcon} alt={isBuyMode ? 'Optional White-Label' : 'Packaging'} className="w-12 h-12 md:w-24 md:h-24" />
            </div>
          </div>

          {/* Step 4: Shipping */}
          <div
            ref={shippingCardRef}
            className="bg-white rounded-xl md:rounded-2xl p-4 md:p-8 md:shadow-lg flex flex-row items-start gap-3 md:gap-6"
          >
            <div className="flex-1">
              <h3 className="text-xl md:text-3xl font-bold mb-1 md:mb-3" style={{ color: '#09543D' }}>
                {isBuyMode ? 'Reliable Delivery' : 'Shipping'}
              </h3>
              <p className="text-gray-700 text-xs md:text-base lg:text-lg leading-tight md:leading-normal">
                {isBuyMode
                  ? 'Products shipped directly to your location or fulfillment partner, on schedule.'
                  : 'Real-time logistics planning. Calculate freight costs and duties before you even place an order.'}
              </p>
            </div>
            <div className="flex-shrink-0">
              <img src={shippingIcon} alt={isBuyMode ? 'Reliable Delivery' : 'Shipping'} className="w-12 h-12 md:w-24 md:h-24" />
            </div>
          </div>
        </div>

        {/* Additional Section Below Cards */}
        <div id="why-choose-us" className="-mt-12 md:pt-12 pb-6 md:pb-8 flex flex-col items-center justify-center lg:min-h-[50vh]">
          <div className="text-center lg:text-center max-w-4xl w-full px-4">
            {/* Title - Stacked on mobile */}
            <h2
              className="text-5xl md:text-6xl lg:text-7xl xl:text-8xl font-bold mb-4 md:mb-6 lg:mb-8 overflow-hidden"
              style={{
                fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                letterSpacing: '-1.3px',
                lineHeight: '0.9',
                color: isBuyMode ? '#09543D' : '#F9F7F1'
              }}
            >
              <span className="block">WHY</span>
              <span className="relative inline-block px-2" style={{ backgroundColor: '#B8F03F', color: '#09543D' }}>
                BRANDS
              </span>
              <span className="block">CHOOSE US</span>
            </h2>

            {/* Description */}
            <p
              className={`text-sm md:text-sm lg:text-lg xl:text-xl text-center max-w-3xl mx-auto overflow-hidden leading-tight md:leading-normal ${isBuyMode ? 'text-[#09543D]' : 'text-[#F9F7F1]'}`}
            >
              Freshness, quality, and trust define your brand. ViaNexta ensures every bag reflects your high standards with:
            </p>
          </div>
        </div>

        {/* Why Brands Choose Us Content Section */}
        <div className="pt-2 pb-32 md:pb-72 lg:pb-96 max-w-7xl mx-auto px-4 lg:px-0">
          <div className="flex flex-col lg:flex-row gap-6 lg:gap-12 items-center">
            {/* Image Placeholder - Appears first on mobile */}
            <div className="w-full lg:w-1/2 order-1 lg:order-1 mb-6 lg:mb-0">
              <div
                className="bg-gray-300 rounded-xl lg:rounded-2xl h-[300px] md:h-[400px] lg:h-[500px] w-full flex items-center justify-center transition-opacity duration-500 overflow-hidden relative shadow-lg"
              >
                {/* Images with crossfade transition */}
                {featureImages.map((img, index) => (
                  <img
                    key={index}
                    src={img}
                    alt={`Feature ${index + 1}`}
                    className={`absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 ease-in-out ${activeIndex === index ? 'opacity-100' : 'opacity-0'
                      }`}
                  />
                ))}
              </div>
            </div>

            {/* Content Sections - Appears second on mobile */}
            <div className="lg:w-1/2 space-y-0 order-1 lg:order-2">
              {/* Section 1: Certified Manufacturers */}
              <div className="pb-4 lg:pb-4">
                <h3
                  className={`text-xl md:text-xl lg:text-2xl font-bold mb-2 ${isBuyMode ? 'text-[#09543D]' : 'text-white lg:text-white'}`}
                  style={{
                    fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                  }}
                >
                  Certified Manufacturers
                </h3>
                <p
                  className={`text-base md:text-base mb-3 ${isBuyMode ? 'text-[#09543D]' : 'text-white lg:text-[#F9F7F1]'}`}
                  style={{
                    fontFamily: "'Poppins', sans-serif"
                  }}
                >
                  Factories and facilities vetted for quality, compliance, and production capability. We pair you with the ideal production partners for your product.
                </p>
                {/* Progress bar */}
                <div className="w-full bg-white rounded-full" style={{ height: '4px' }}>
                  <div
                    className="bg-[#B8F03F] rounded-full transition-all duration-300 ease-out"
                    style={{ height: '4px', width: `${progressValues[0]}%` }}
                  />
                </div>
              </div>

              {/* Section 2: Ethically Sourced Ingredients & Materials */}
              <div className="pb-4 lg:pb-4">
                <h3
                  className={`text-xl md:text-xl lg:text-2xl font-bold mb-2 ${isBuyMode ? 'text-[#09543D]' : 'text-white lg:text-white'}`}
                  style={{
                    fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                  }}
                >
                  Ethically Sourced Ingredients & Materials
                </h3>
                <p
                  className={`text-base md:text-base mb-3 ${isBuyMode ? 'text-[#09543D]' : 'text-white lg:text-[#F9F7F1]'}`}
                  style={{
                    fontFamily: "'Poppins', sans-serif"
                  }}
                >
                  Responsible sourcing across food, beauty, wellness, and general CPG categories.
                </p>
                {/* Progress bar */}
                <div className="w-full bg-white rounded-full" style={{ height: '4px' }}>
                  <div
                    className="bg-[#B8F03F] rounded-full transition-all duration-300 ease-out"
                    style={{ height: '4px', width: `${progressValues[1]}%` }}
                  />
                </div>
              </div>

              {/* Section 3: Verified Warehouses & Fulfillment Partners */}
              <div className="pb-4 lg:pb-4">
                <h3
                  className={`text-xl md:text-xl lg:text-2xl font-bold mb-2 ${isBuyMode ? 'text-[#09543D]' : 'text-white lg:text-white'}`}
                  style={{
                    fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                  }}
                >
                  Verified Warehouses & Fulfillment Partners
                </h3>
                <p
                  className={`text-base md:text-base mb-3 ${isBuyMode ? 'text-[#09543D]' : 'text-white lg:text-[#F9F7F1]'}`}
                  style={{
                    fontFamily: "'Poppins', sans-serif"
                  }}
                >
                  Secure, compliant, and scalable storage + distribution solutions.
                </p>
                {/* Progress bar */}
                <div className="w-full bg-white rounded-full" style={{ height: '4px' }}>
                  <div
                    className="bg-[#B8F03F] rounded-full transition-all duration-300 ease-out"
                    style={{ height: '4px', width: `${progressValues[2]}%` }}
                  />
                </div>
              </div>

              {/* Section 4: Premium Packaging & Customization */}
              <div className="pb-4 lg:pb-4">
                <h3
                  className={`text-xl md:text-xl lg:text-2xl font-bold mb-2 ${isBuyMode ? 'text-[#09543D]' : 'text-white lg:text-white'}`}
                  style={{
                    fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                  }}
                >
                  Premium Packaging & Customization
                </h3>
                <p
                  className={`text-base md:text-base mb-3 ${isBuyMode ? 'text-[#09543D]' : 'text-white lg:text-[#F9F7F1]'}`}
                  style={{
                    fontFamily: "'Poppins', sans-serif"
                  }}
                >
                  Tailored packaging that aligns with your brand identity across all product categories.
                </p>
                {/* Progress bar */}
                <div className="w-full bg-white rounded-full" style={{ height: '4px' }}>
                  <div
                    className="bg-[#B8F03F] rounded-full transition-all duration-300 ease-out"
                    style={{ height: '4px', width: `${progressValues[3]}%` }}
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  )
}

export default FromIdeaToInventory


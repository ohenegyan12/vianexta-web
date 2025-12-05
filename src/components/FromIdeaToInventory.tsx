import { useEffect, useRef, useState } from 'react'
import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'
import SplitType from 'split-type'

gsap.registerPlugin(ScrollTrigger)
const fromIdeaBg = '/assets/from-idea.svg'
import sourcingIcon from '../../assets/sourcing.svg'
import brandingIcon from '../../assets/branding.svg'
import packagingIcon from '../../assets/packaging.svg'
import shippingIcon from '../../assets/shipping.svg'

interface FromIdeaToInventoryProps {
  isBuyMode: boolean
}

function FromIdeaToInventory({ isBuyMode }: FromIdeaToInventoryProps) {
  const titleRef = useRef<HTMLHeadingElement>(null)
  const descriptionRef = useRef<HTMLParagraphElement>(null)
  const whyBrandsTitleRef = useRef<HTMLHeadingElement>(null)
  const whyBrandsDesc1Ref = useRef<HTMLParagraphElement>(null)
  const sourcingCardRef = useRef<HTMLDivElement>(null)
  const brandingCardRef = useRef<HTMLDivElement>(null)
  const packagingCardRef = useRef<HTMLDivElement>(null)
  const shippingCardRef = useRef<HTMLDivElement>(null)
  const [backgroundSize, setBackgroundSize] = useState('120% 100%')
  const [backgroundPosition, setBackgroundPosition] = useState('top center')
  const [isMobile, setIsMobile] = useState(false)

  useEffect(() => {
    // Handle responsive background size and position
    const updateBackground = () => {
      const mobile = window.innerWidth < 768
      setIsMobile(mobile)
      if (mobile) {
        setBackgroundSize('70% 80%')
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

  useEffect(() => {
    let titleSplit: SplitType | null = null
    
    // Use requestAnimationFrame to ensure DOM is ready after key change
    const timer = requestAnimationFrame(() => {
      if (titleRef.current) {
        titleSplit = new SplitType(titleRef.current, {
          types: 'words,chars',
          lineClass: 'split-line'
        })

        gsap.from(titleSplit.chars, {
          scrollTrigger: {
            trigger: titleRef.current,
            start: 'top 80%',
            toggleActions: 'play none none reverse'
          },
          duration: 0.4,
          ease: 'circ.out',
          y: 80,
          opacity: 0,
          stagger: 0.01
        })
      }
    })

    // Cleanup
    return () => {
      cancelAnimationFrame(timer)
      if (titleSplit) {
        titleSplit.revert()
      }
    }
  }, [isBuyMode])

  useEffect(() => {
    let descriptionSplit: SplitType | null = null
    
    // Use requestAnimationFrame to ensure DOM is ready after key change
    const timer = requestAnimationFrame(() => {
      if (descriptionRef.current) {
        descriptionSplit = new SplitType(descriptionRef.current, {
          types: 'words,chars',
          lineClass: 'split-line'
        })

        gsap.from(descriptionSplit.chars, {
          scrollTrigger: {
            trigger: descriptionRef.current,
            start: 'top 80%',
            toggleActions: 'play none none reverse'
          },
          duration: 0.4,
          ease: 'circ.out',
          y: 80,
          opacity: 0,
          stagger: 0.01
        })
      }
    })

    // Cleanup
    return () => {
      cancelAnimationFrame(timer)
      if (descriptionSplit) {
        descriptionSplit.revert()
      }
    }
  }, [isBuyMode])

  useEffect(() => {
    // Animate why brands title
    if (whyBrandsTitleRef.current) {
      const titleSplit = new SplitType(whyBrandsTitleRef.current, {
        types: 'words,chars',
        lineClass: 'split-line'
      })

      gsap.from(titleSplit.chars, {
        scrollTrigger: {
          trigger: whyBrandsTitleRef.current,
          start: 'top 80%',
          toggleActions: 'play none none reverse'
        },
        duration: 0.4,
        ease: 'circ.out',
        y: 80,
        opacity: 0,
        stagger: 0.01
      })

      // Cleanup
      return () => {
        titleSplit.revert()
      }
    }
  }, [])

  useEffect(() => {
    // Animate why brands description
    if (whyBrandsDesc1Ref.current) {
      const descSplit = new SplitType(whyBrandsDesc1Ref.current, {
        types: 'words,chars',
        lineClass: 'split-line'
      })

      gsap.from(descSplit.chars, {
        scrollTrigger: {
          trigger: whyBrandsDesc1Ref.current,
          start: 'top 80%',
          toggleActions: 'play none none reverse'
        },
        duration: 0.4,
        ease: 'circ.out',
        y: 80,
        opacity: 0,
        stagger: 0.01
      })

      // Cleanup
      return () => {
        descSplit.revert()
      }
    }
  }, [])

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
      className="relative overflow-hidden" 
      style={{ 
        minHeight: isMobile ? 'auto' : '150vh',
        width: '110vw',
        position: 'relative',
        left: '50%',
        marginLeft: '-55vw',
        marginRight: '-55vw',
        backgroundColor: isBuyMode ? (isMobile ? '#F8F7F1' : '#09543D') : (isMobile ? '#09543D' : 'transparent')
      }}
    >
      {/* Background SVG - Hidden on mobile */}
      <div 
        className="absolute inset-0 w-full h-full hidden md:block"
        style={{
          backgroundImage: isBuyMode ? 'none' : `url(${fromIdeaBg})`,
          backgroundColor: isBuyMode ? '#F8F7F1' : 'transparent',
          backgroundSize: backgroundSize,
          backgroundPosition: backgroundPosition,
          backgroundRepeat: 'no-repeat',
          pointerEvents: 'none',
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
              ref={titleRef}
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
                ref={descriptionRef}
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
        <div className="-mt-12 md:pt-12 pb-6 md:pb-8 flex flex-col items-center justify-center lg:min-h-[50vh]">
          <div className="text-center lg:text-center max-w-4xl w-full px-4">
            {/* Title - Stacked on mobile */}
            <h2 
              ref={whyBrandsTitleRef}
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
              ref={whyBrandsDesc1Ref}
              className={`text-sm md:text-sm lg:text-lg xl:text-xl text-center max-w-3xl mx-auto overflow-hidden leading-tight md:leading-normal ${isBuyMode ? 'text-[#09543D]' : 'text-[#F9F7F1]'}`}
            >
              Freshness, quality, and trust define your brand. ViaNexta ensures every bag reflects your high standards with:
            </p>
          </div>
        </div>

        {/* Why Brands Choose Us Content Section */}
        <div className="pt-2 pb-32 md:pb-72 lg:pb-96 max-w-7xl mx-auto px-4 lg:px-0">
          <div className="flex flex-col lg:flex-row gap-6 lg:gap-12 items-stretch">
            {/* Placeholder Box - Appears first on mobile */}
            <div className="lg:w-1/2 order-2 lg:order-1">
              <div 
                className="bg-gray-300 rounded-xl lg:rounded-2xl h-64 lg:h-full min-h-[300px]"
              >
                {/* Empty card - will hold images later */}
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
                    className="bg-[#B8F03F] rounded-full transition-all duration-500"
                    style={{ height: '4px', width: '85%' }}
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
                    className="bg-[#B8F03F] rounded-full transition-all duration-500"
                    style={{ height: '4px', width: '70%' }}
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
                    className="bg-[#B8F03F] rounded-full transition-all duration-500"
                    style={{ height: '4px', width: '90%' }}
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
                    className="bg-[#B8F03F] rounded-full transition-all duration-500"
                    style={{ height: '4px', width: '75%' }}
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


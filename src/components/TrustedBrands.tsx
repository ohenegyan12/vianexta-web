import { useEffect, useRef } from 'react'
import { gsap } from 'gsap'
import brandLogo1 from '../../assets/brand-logo-1.png'
import brandLogo2 from '../../assets/brand-logo-2.png'
import brandLogo3 from '../../assets/brand-logo-3.png'
import brandLogo4 from '../../assets/brand-logo-4.png'
import brandLogo5 from '../../assets/brand-logo-5.png'
import brandLogo6 from '../../assets/brand-logo-6.png'
import brandLogo7 from '../../assets/brand-logo-7.png'

function TrustedBrands() {
  const scrollContainerRef = useRef<HTMLDivElement>(null)
  const animationRef = useRef<gsap.core.Tween | null>(null)

  const logos = [
    brandLogo1,
    brandLogo2,
    brandLogo3,
    brandLogo4,
    brandLogo5,
    brandLogo6,
    brandLogo7
  ]

  useEffect(() => {
    if (!scrollContainerRef.current) return

    // Create animation
    animationRef.current = gsap.to(scrollContainerRef.current, {
      x: `-${scrollContainerRef.current.scrollWidth / 2}px`,
      duration: 20,
      ease: 'none',
      repeat: -1
    })

    return () => {
      if (animationRef.current) {
        animationRef.current.kill()
      }
    }
  }, [])

  const handleMouseEnter = () => {
    if (animationRef.current) {
      animationRef.current.timeScale(0.3) // Slow down to 30% speed
    }
  }

  const handleMouseLeave = () => {
    if (animationRef.current) {
      animationRef.current.timeScale(1) // Return to normal speed
    }
  }

  return (
    <section className="relative bg-[#F9F7F1] py-20 md:py-32">
      <div className="container mx-auto px-4">
        <div className="flex flex-col items-center mb-12 md:mb-16">
          {/* Title */}
          <h2 
            className="font-bold text-center text-gray-700 text-lg md:text-xl uppercase tracking-wide"
          >
            TRUSTED BY BUSINESSES BIG AND SMALL, EVERYWHERE
          </h2>
        </div>

        {/* Scrolling Logos */}
        <div 
          className="overflow-hidden"
          onMouseEnter={handleMouseEnter}
          onMouseLeave={handleMouseLeave}
        >
          <div 
            ref={scrollContainerRef}
            className="flex gap-8 md:gap-12 lg:gap-16 items-center"
            style={{ width: 'fit-content' }}
          >
            {/* First set of logos */}
            {logos.map((logo, index) => (
              <div 
                key={`first-${index}`}
                className="flex-shrink-0"
                style={{ height: '150px', display: 'flex', alignItems: 'center' }}
              >
                <img 
                  src={logo} 
                  alt={`Brand ${index + 1}`}
                  className="h-full w-auto object-contain opacity-70 hover:opacity-100 transition-opacity"
                />
              </div>
            ))}
            {/* Duplicate set for seamless loop */}
            {logos.map((logo, index) => (
              <div 
                key={`second-${index}`}
                className="flex-shrink-0"
                style={{ height: '150px', display: 'flex', alignItems: 'center' }}
              >
                <img 
                  src={logo} 
                  alt={`Brand ${index + 1}`}
                  className="h-full w-auto object-contain opacity-70 hover:opacity-100 transition-opacity"
                />
              </div>
            ))}
          </div>
        </div>
      </div>
    </section>
  )
}

export default TrustedBrands


import { useEffect, useRef } from 'react'
import { gsap } from 'gsap'


function HearFromCustomers() {
  const leftColumnRef = useRef<HTMLDivElement>(null)
  const rightColumnRef = useRef<HTMLDivElement>(null)
  const leftColumnDesktopRef = useRef<HTMLDivElement>(null)
  const rightColumnDesktopRef = useRef<HTMLDivElement>(null)
  const animationTimelineRef = useRef<gsap.core.Timeline | null>(null)

  // Real customer testimonials
  const testimonials = [
    {
      name: '@danieraezorsharp',
      rating: 5,
      text: 'Ooouuu!!! This is TOP TIER!!!'
    },
    {
      name: '@mrwld101',
      rating: 5,
      text: 'That\'s the way you do it! Big things'
    },
    {
      name: '@designgym.co',
      rating: 5,
      text: 'Was introduced to your coffee thanks to @amplify @bphlfest'
    },
    {
      name: '@rachboogie215',
      rating: 5,
      text: 'Love this! Yes'
    },
    {
      name: '@angelicmolos',
      rating: 5,
      text: 'OMG!!!!'
    },
    {
      name: '@bean2beancoffeeco',
      rating: 5,
      text: 'It\'s so goooooddd'
    },
    {
      name: '@thechocolatebarista',
      rating: 5,
      text: 'More of this!!'
    },
    {
      name: '@delhibakery',
      rating: 5,
      text: 'So dope'
    },
    {
      name: '@browngirlsbrew',
      rating: 5,
      text: '#winning'
    },
    {
      name: '@beijaflornaturals',
      rating: 5,
      text: 'I love this. Can\'t wait to grab a coffee.'
    },
    {
      name: '@mznoname82',
      rating: 5,
      text: 'Really amazing and inspiring!'
    },
    {
      name: '@dachickenshack',
      rating: 5,
      text: 'Amazing!!! Keep breaking barriers!'
    }
  ]

  // Duplicate testimonials multiple times for seamless infinite loop
  // Using 20 sets to ensure both columns always have content visible and smooth scrolling
  const duplicatedTestimonials = [
    ...testimonials,
    ...testimonials,
    ...testimonials,
    ...testimonials,
    ...testimonials,
    ...testimonials,
    ...testimonials,
    ...testimonials,
    ...testimonials,
    ...testimonials,
    ...testimonials,
    ...testimonials,
    ...testimonials,
    ...testimonials,
    ...testimonials,
    ...testimonials,
    ...testimonials,
    ...testimonials,
    ...testimonials,
    ...testimonials
  ]



  useEffect(() => {
    const setupAnimation = () => {
      const isMobile = window.innerWidth < 768

      // Kill existing timeline
      if (animationTimelineRef.current) {
        animationTimelineRef.current.kill()
        animationTimelineRef.current = null
      }

      if (isMobile) {
        // Mobile: Horizontal scrolling
        if (!leftColumnRef.current || !rightColumnRef.current) return

        // Wait for layout to be ready
        requestAnimationFrame(() => {
          const leftWidth = leftColumnRef.current?.scrollWidth || 0
          const rightWidth = rightColumnRef.current?.scrollWidth || 0

          if (leftWidth === 0 || rightWidth === 0) {
            setTimeout(setupAnimation, 100)
            return
          }

          // For seamless infinite loop: scroll by exactly half the width
          // This ensures when it loops, the duplicate content is in the exact same position
          const leftScrollDistance = leftWidth / 2
          const rightScrollDistance = rightWidth / 2

          // Reset positions to ensure clean start
          // Right column starts offset to the left so it can scroll in seamlessly
          gsap.set(leftColumnRef.current, { x: 0, force3D: true })
          gsap.set(rightColumnRef.current, { x: -rightScrollDistance, force3D: true })

          // Horizontal scrolling on mobile - columns move in opposite directions
          animationTimelineRef.current = gsap.timeline({
            repeat: -1,
            paused: false
          })

          animationTimelineRef.current
            .to(leftColumnRef.current, {
              x: -leftScrollDistance,
              duration: 600,
              ease: 'none',
              force3D: true,
              immediateRender: false
            }, 0)
            .to(rightColumnRef.current, {
              x: rightScrollDistance,
              duration: 600,
              ease: 'none',
              force3D: true,
              immediateRender: false
            }, 0)
        })
      } else {
        // Desktop: Vertical scrolling in opposite directions
        if (!leftColumnDesktopRef.current || !rightColumnDesktopRef.current) return

        // Wait for layout to be ready
        requestAnimationFrame(() => {
          const leftHeight = leftColumnDesktopRef.current?.scrollHeight || 0
          const rightHeight = rightColumnDesktopRef.current?.scrollHeight || 0

          if (leftHeight === 0 || rightHeight === 0) {
            setTimeout(setupAnimation, 100)
            return
          }

          // For seamless infinite loop: scroll by exactly half the height
          // This ensures when it loops, the duplicate content is in the exact same position
          const scrollDistance = leftHeight / 2

          // Left column: starts at top (0), scrolls up (negative y) - content comes from bottom
          // Right column: starts offset up (-scrollDistance), scrolls down (to 0) - content comes from top
          gsap.set(leftColumnDesktopRef.current, { y: 0, force3D: true })
          gsap.set(rightColumnDesktopRef.current, { y: -scrollDistance, force3D: true })

          // Vertical scrolling on desktop - columns move in opposite directions
          animationTimelineRef.current = gsap.timeline({
            repeat: -1,
            paused: false
          })

          animationTimelineRef.current
            .to(leftColumnDesktopRef.current, {
              y: -scrollDistance,
              duration: 600,
              ease: 'none',
              force3D: true,
              immediateRender: false
            }, 0)
            .to(rightColumnDesktopRef.current, {
              y: 0,
              duration: 600,
              ease: 'none',
              force3D: true,
              immediateRender: false
            }, 0)
        })
      }
    }

    // Small delay to ensure DOM is ready
    const timeoutId = setTimeout(() => {
      setupAnimation()
    }, 100)

    // Recalculate on window resize with debounce
    let resizeTimeout: ReturnType<typeof setTimeout>
    const handleResize = () => {
      clearTimeout(resizeTimeout)
      resizeTimeout = setTimeout(() => {
        setupAnimation()
      }, 150)
    }
    window.addEventListener('resize', handleResize)

    return () => {
      clearTimeout(timeoutId)
      clearTimeout(resizeTimeout)
      window.removeEventListener('resize', handleResize)
      if (animationTimelineRef.current) {
        animationTimelineRef.current.kill()
      }
    }
  }, [])

  const renderStars = (rating: number) => {
    return Array.from({ length: 5 }, (_, i) => (
      <span key={i} className={i < rating ? 'text-yellow-400' : 'text-gray-300'}>
        ★
      </span>
    ))
  }

  return (
    <section id="hear-from-customers" className="relative bg-[#F9F7F1] py-20 md:py-32">
      <div className="container mx-auto px-4">
        <div className="flex flex-col lg:flex-row gap-12 lg:gap-16 items-start">
          {/* Left Side - Title */}
          <div className="lg:w-1/2 w-full">
            <h2
              className="font-bold mb-4 overflow-hidden text-center lg:text-left"
              style={{
                fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                letterSpacing: '-1.3px',
                lineHeight: '0.9',
                color: '#09543D'
              }}
            >
              <span className="block text-6xl md:text-6xl lg:text-7xl xl:text-8xl">HEAR FROM</span>
              <span className="block text-6xl md:text-6xl lg:text-7xl xl:text-8xl">OUR CUSTOMERS</span>
            </h2>
          </div>

          {/* Right Side - Cards */}
          <div className="lg:w-1/2 w-full">
            {/* Mobile: Horizontal Scrolling Cards */}
            <div className="md:hidden relative overflow-hidden h-[500px]">
              {/* Left Column - Scrolls Left, Horizontal Row at Top */}
              <div className="absolute top-0 left-0 w-full overflow-hidden">
                <div ref={leftColumnRef} className="flex flex-row gap-4" style={{ width: 'max-content', willChange: 'transform' }}>
                  {duplicatedTestimonials.map((testimonial, index) => (
                    <div
                      key={`left-${index}`}
                      className="bg-white rounded-xl p-4 flex-shrink-0 w-[280px]"
                    >
                      <div className="flex gap-1 mb-3 text-lg">
                        {renderStars(testimonial.rating)}
                      </div>
                      <p className="text-gray-700 text-sm mb-4 leading-relaxed">
                        {testimonial.text}
                      </p>
                      <p className="font-semibold text-gray-900 text-sm">
                        {testimonial.name}
                      </p>
                    </div>
                  ))}
                </div>
              </div>

              {/* Right Column - Scrolls Right, Horizontal Row Below Top */}
              <div className="absolute top-[200px] left-0 w-full overflow-hidden">
                <div ref={rightColumnRef} className="flex flex-row gap-4" style={{ width: 'max-content', willChange: 'transform' }}>
                  {duplicatedTestimonials.map((testimonial, index) => (
                    <div
                      key={`right-${index}`}
                      className="bg-white rounded-xl p-4 flex-shrink-0 w-[280px]"
                    >
                      <div className="flex gap-1 mb-3 text-lg">
                        {renderStars(testimonial.rating)}
                      </div>
                      <p className="text-gray-700 text-sm mb-4 leading-relaxed">
                        {testimonial.text}
                      </p>
                      <p className="font-semibold text-gray-900 text-sm">
                        {testimonial.name}
                      </p>
                    </div>
                  ))}
                </div>
              </div>
            </div>

            {/* Desktop: 2-Column Scrolling Cards */}
            <div className="hidden md:flex md:gap-6 relative overflow-hidden h-[600px]">
              {/* Left Column - Scrolls Up */}
              <div className="w-1/2 relative overflow-hidden">
                <div ref={leftColumnDesktopRef} className="flex flex-col gap-6" style={{ height: 'max-content', willChange: 'transform' }}>
                  {duplicatedTestimonials.map((testimonial, index) => (
                    <div
                      key={`left-desktop-${index}`}
                      className="bg-white rounded-xl p-6 flex-shrink-0"
                    >
                      <div className="flex gap-1 mb-3 text-lg">
                        {renderStars(testimonial.rating)}
                      </div>
                      <p className="text-gray-700 text-base mb-4 leading-relaxed">
                        {testimonial.text}
                      </p>
                      <p className="font-semibold text-gray-900 text-base">
                        {testimonial.name}
                      </p>
                    </div>
                  ))}
                </div>
              </div>

              {/* Right Column - Scrolls Down */}
              <div className="w-1/2 relative overflow-hidden">
                <div ref={rightColumnDesktopRef} className="flex flex-col gap-6" style={{ height: 'max-content', willChange: 'transform' }}>
                  {duplicatedTestimonials.map((testimonial, index) => (
                    <div
                      key={`right-desktop-${index}`}
                      className="bg-white rounded-xl p-6 flex-shrink-0"
                    >
                      <div className="flex gap-1 mb-3 text-lg">
                        {renderStars(testimonial.rating)}
                      </div>
                      <p className="text-gray-700 text-base mb-4 leading-relaxed">
                        {testimonial.text}
                      </p>
                      <p className="font-semibold text-gray-900 text-base">
                        {testimonial.name}
                      </p>
                    </div>
                  ))}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  )
}

export default HearFromCustomers


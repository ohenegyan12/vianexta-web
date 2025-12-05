import { useEffect, useRef } from 'react'
import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'
import SplitType from 'split-type'

gsap.registerPlugin(ScrollTrigger)

function HearFromCustomers() {
  const titleRef = useRef<HTMLHeadingElement>(null)
  const leftColumnRef = useRef<HTMLDivElement>(null)
  const rightColumnRef = useRef<HTMLDivElement>(null)
  const animationTimelineRef = useRef<gsap.core.Timeline | null>(null)

  // Sample testimonials - you can replace with actual data
  const testimonials = [
    {
      name: 'Parth Mangukiya',
      rating: 5,
      text: 'Tried several features, very impressive. Used it to host my images to get them served via CDN. A great feature to have!'
    },
    {
      name: 'Anand Singh',
      rating: 5,
      text: 'Super lucid interface. It\'s a joy to work with!'
    },
    {
      name: 'Swathi Kartha',
      rating: 5,
      text: 'The product is well suited to transform catalog images for e-commerce businesses, especially if you are on the lookout for a tool that does re-sizing and background edits in bulk in record time.'
    },
    {
      name: 'Darpan Pathak',
      rating: 5,
      text: 'Pixelbin.io has been a game-changer for me when it comes to image optimization. It\'s super easy to use, integrates smoothly with my tech stack, and saves so much time.'
    },
    {
      name: 'Shubham Srivastava',
      rating: 4,
      text: 'A powerful solution that caters to all my image transformation needs.'
    },
    {
      name: 'Pritam Ghosh',
      rating: 5,
      text: 'Easy to use with multiple editing features. My go to editing tool. Love it!'
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
    // Animate title
    if (titleRef.current) {
      const titleSplit = new SplitType(titleRef.current, {
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

      // Cleanup
      return () => {
        titleSplit.revert()
      }
    }
  }, [])

  useEffect(() => {
    if (!leftColumnRef.current || !rightColumnRef.current) return

    const setupAnimation = () => {
      const isMobile = window.innerWidth < 768
      
      // Wait for layout to be ready
      if (isMobile) {
        // For mobile: use scrollWidth for horizontal scrolling
        const leftWidth = leftColumnRef.current?.scrollWidth || 0
        const rightWidth = rightColumnRef.current?.scrollWidth || 0

        if (leftWidth === 0 || rightWidth === 0) {
          setTimeout(setupAnimation, 100)
          return
        }

        // Kill existing timeline
        if (animationTimelineRef.current) {
          animationTimelineRef.current.kill()
        }

        // For seamless infinite loop: scroll by half the width
        const scrollDistance = leftWidth / 2

        // Horizontal scrolling on mobile - columns move in opposite directions
        animationTimelineRef.current = gsap.timeline({ repeat: -1 })
        animationTimelineRef.current
          .fromTo(leftColumnRef.current, 
            { x: 0 },
            {
              x: -scrollDistance,
              duration: 180,
              ease: 'none',
              immediateRender: false
            }, 
            0
          )
          .fromTo(rightColumnRef.current,
            { x: 0 },
            {
              x: scrollDistance,
              duration: 180,
              ease: 'none',
              immediateRender: false
            },
            0
          )
      } else {
        // For desktop: use scrollHeight for vertical scrolling
        const leftHeight = leftColumnRef.current?.scrollHeight || 0
        const rightHeight = rightColumnRef.current?.scrollHeight || 0

        if (leftHeight === 0 || rightHeight === 0) {
          setTimeout(setupAnimation, 100)
          return
        }

        // Kill existing timeline
        if (animationTimelineRef.current) {
          animationTimelineRef.current.kill()
        }

        // For seamless infinite loop: scroll by half the height
        const scrollDistance = leftHeight / 2

        // Vertical scrolling on desktop
        animationTimelineRef.current = gsap.timeline({ repeat: -1 })
        animationTimelineRef.current
          .fromTo(leftColumnRef.current, 
            { y: 0 },
            {
              y: scrollDistance,
              duration: 180,
              ease: 'none',
              immediateRender: false
            }, 
            0
          )
          .fromTo(rightColumnRef.current,
            { y: 0 },
            {
              y: -scrollDistance,
              duration: 180,
              ease: 'none',
              immediateRender: false
            },
            0
          )
      }
    }

    setupAnimation()

    // Recalculate on window resize
    const handleResize = () => {
      setupAnimation()
    }
    window.addEventListener('resize', handleResize)

    return () => {
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
    <section className="relative bg-[#F9F7F1] py-20 md:py-32">
      <div className="container mx-auto px-4">
        <div className="flex flex-col lg:flex-row gap-12 lg:gap-16 items-start">
          {/* Left Side - Title */}
          <div className="lg:w-1/2 w-full">
            <h2 
              ref={titleRef}
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

          {/* Right Side - Scrolling Cards */}
          <div className="lg:w-1/2 w-full relative overflow-hidden h-[500px] md:h-[600px]">
            {/* Left Column - Scrolls Left, Horizontal Row at Top */}
            <div className="absolute top-0 left-0 w-full overflow-hidden">
              <div ref={leftColumnRef} className="flex flex-row md:flex-col gap-4 md:gap-6" style={{ width: 'max-content' }}>
                {duplicatedTestimonials.map((testimonial, index) => (
                  <div
                    key={`left-${index}`}
                    className="bg-white rounded-xl p-4 md:p-6 flex-shrink-0 w-[280px] md:w-auto"
                  >
                    <div className="flex gap-1 mb-3 text-lg">
                      {renderStars(testimonial.rating)}
                    </div>
                    <p className="text-gray-700 text-sm md:text-base mb-4 leading-relaxed">
                      {testimonial.text}
                    </p>
                    <p className="font-semibold text-gray-900 text-sm md:text-base">
                      {testimonial.name}
                    </p>
                  </div>
                ))}
              </div>
            </div>

            {/* Right Column - Scrolls Right, Horizontal Row Below Top */}
            <div className="absolute top-[280px] md:top-0 left-0 w-full overflow-hidden md:relative">
              <div ref={rightColumnRef} className="flex flex-row md:flex-col gap-4 md:gap-6 ml-[140px] md:ml-0" style={{ width: 'max-content' }}>
                {duplicatedTestimonials.map((testimonial, index) => (
                  <div
                    key={`right-${index}`}
                    className="bg-white rounded-xl p-4 md:p-6 flex-shrink-0 w-[280px] md:w-auto"
                  >
                    <div className="flex gap-1 mb-3 text-lg">
                      {renderStars(testimonial.rating)}
                    </div>
                    <p className="text-gray-700 text-sm md:text-base mb-4 leading-relaxed">
                      {testimonial.text}
                    </p>
                    <p className="font-semibold text-gray-900 text-sm md:text-base">
                      {testimonial.name}
                    </p>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  )
}

export default HearFromCustomers


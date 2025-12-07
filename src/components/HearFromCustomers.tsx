import { useEffect, useRef } from 'react'
import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'
import SplitType from 'split-type'

gsap.registerPlugin(ScrollTrigger)

function HearFromCustomers() {
  const titleRef = useRef<HTMLHeadingElement>(null)
  const leftColumnRef = useRef<HTMLDivElement>(null)
  const rightColumnRef = useRef<HTMLDivElement>(null)
  const leftColumnDesktopRef = useRef<HTMLDivElement>(null)
  const rightColumnDesktopRef = useRef<HTMLDivElement>(null)
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
    },
    {
      name: 'Rahul Mehta',
      rating: 5,
      text: 'The API integration was seamless and the documentation is excellent. Saved us weeks of development time!'
    },
    {
      name: 'Priya Sharma',
      rating: 5,
      text: 'Outstanding customer support and the platform is incredibly reliable. Highly recommend for any business dealing with images.'
    },
    {
      name: 'Vikram Patel',
      rating: 5,
      text: 'The bulk processing feature is a lifesaver. We process thousands of images daily and it handles everything perfectly.'
    },
    {
      name: 'Neha Desai',
      rating: 5,
      text: 'Love how intuitive the interface is. Even our non-technical team members can use it without any training.'
    },
    {
      name: 'Arjun Kumar',
      rating: 5,
      text: 'The CDN delivery is incredibly fast. Our page load times improved significantly after switching to this platform.'
    },
    {
      name: 'Sneha Reddy',
      rating: 5,
      text: 'Best investment we made for our e-commerce store. The image optimization features are top-notch.'
    },
    {
      name: 'Karan Malhotra',
      rating: 5,
      text: 'The background removal tool works flawlessly. It\'s saved us so much time and money on manual editing.'
    },
    {
      name: 'Meera Joshi',
      rating: 5,
      text: 'Excellent platform with great features. The real-time transformations are impressive and the quality is always perfect.'
    },
    {
      name: 'Amit Verma',
      rating: 5,
      text: 'The pricing is very reasonable for what you get. We\'ve seen a huge improvement in our workflow efficiency.'
    },
    {
      name: 'Divya Nair',
      rating: 5,
      text: 'The platform scales beautifully with our growing business. Never had any performance issues even during peak times.'
    },
    {
      name: 'Rohit Agarwal',
      rating: 5,
      text: 'The watermarking feature is exactly what we needed. Simple to use and produces professional results every time.'
    },
    {
      name: 'Kavita Iyer',
      rating: 5,
      text: 'Amazing service! The team is responsive and the platform keeps getting better with regular updates.'
    },
    {
      name: 'Nikhil Rao',
      rating: 5,
      text: 'The format conversion capabilities are extensive. We can handle any image format our clients throw at us.'
    },
    {
      name: 'Anjali Menon',
      rating: 5,
      text: 'Perfect solution for our marketing team. The image transformations help us create stunning visuals quickly.'
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
          const scrollDistance = leftWidth / 2

          // Reset positions to ensure clean start
          gsap.set(leftColumnRef.current, { x: 0, force3D: true })
          gsap.set(rightColumnRef.current, { x: 0, force3D: true })

          // Horizontal scrolling on mobile - columns move in opposite directions
          animationTimelineRef.current = gsap.timeline({ 
            repeat: -1,
            paused: false
          })
          
          animationTimelineRef.current
            .to(leftColumnRef.current, {
              x: -scrollDistance,
              duration: 600,
              ease: 'none',
              force3D: true,
              immediateRender: false
            }, 0)
            .to(rightColumnRef.current, {
              x: scrollDistance,
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
    <section id="testimonials" className="relative bg-[#F9F7F1] py-20 md:py-32">
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
              <div className="absolute top-[280px] left-0 w-full overflow-hidden">
                <div ref={rightColumnRef} className="flex flex-row gap-4 ml-[140px]" style={{ width: 'max-content', willChange: 'transform' }}>
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


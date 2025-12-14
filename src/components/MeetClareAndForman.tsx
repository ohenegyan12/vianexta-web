import { useState, useEffect, useRef } from 'react'
import { gsap } from 'gsap'

interface MeetClareAndFormanProps {
  isBuyMode: boolean
}

function MeetClareAndForman({ isBuyMode }: MeetClareAndFormanProps) {
  const [activeTab, setActiveTab] = useState<'CLARE' | 'FORMAN'>('CLARE')
  const clareRef = useRef<HTMLSpanElement>(null)
  const formanRef = useRef<HTMLSpanElement>(null)
  const highlightRef = useRef<HTMLSpanElement>(null)

  const clareFeatures = [
    {
      icon: '🔧',
      title: 'Product Definition',
      description: 'Clare helps you define and refine your core product concept, transforming your vision into a concrete plan.'
    },
    {
      icon: '🔍',
      title: 'Insight Analysis',
      description: 'Clare analyzes your website and brand brief, extracting insights to ensure your product aligns with your brand identity.'
    },
    {
      icon: '💡',
      title: 'Strategic Recommendations',
      description: 'Based on Clare\'s analysis, Clare recommends optimal product specifications, packaging, and pricing.'
    },
    {
      icon: '✅',
      title: 'Detail Consolidation',
      description: 'Intelligently gathers and organizes all critical production details required to move your project forward.'
    },
    {
      icon: '⚡',
      title: 'Information Coordination',
      description: 'Acts as your central hub, coordinating all sales data and account information in one organized place.'
    },
    {
      icon: '📦',
      title: 'Automated Handoff',
      description: 'Packages your finalized order with precision and sends it to Forman, making it instantly ready for execution.'
    }
  ]

  const formanFeatures = [
    {
      icon: '🔗',
      title: 'Intelligent Sourcing',
      description: 'Forman takes the lead on your supply chain, automatically handling material sourcing and supplier communications.'
    },
    {
      icon: '👁️',
      title: 'Production Oversight',
      description: 'Forman flawlessly processes the specifications from Clare and manages the day-to-day production timelines on your behalf.'
    },
    {
      icon: '🚚',
      title: 'End-to-End Fulfillment',
      description: 'Manages the entire fulfillment process, from final product assembly and packaging to shipping and logistics.'
    },
    {
      icon: '💰',
      title: 'Automated Financials',
      description: 'Streamlines your finances by automatically taking care of all supplier payments and customer invoicing.'
    },
    {
      icon: '📍',
      title: 'Live Order Tracking',
      description: 'Provides complete visibility by tracking your entire order from the factory floor to the final delivery address.'
    },
    {
      icon: '🔄',
      title: 'Synchronized Updates',
      description: 'Keeps Clare and your team updated in real-time, ensuring everyone is in the loop from start to finish.'
    }
  ]

  // Initial setup - position highlight on CLARE
  useEffect(() => {
    if (!highlightRef.current || !clareRef.current) return

    const updateHighlight = (target: HTMLElement, animate: boolean = false) => {
      if (!highlightRef.current) return
      
      const targetRect = target.getBoundingClientRect()
      const container = highlightRef.current.offsetParent as HTMLElement
      if (!container) return
      
      const containerRect = container.getBoundingClientRect()

      const targetLeft = targetRect.left - containerRect.left
      const targetTop = targetRect.top - containerRect.top
      const targetWidth = targetRect.width
      const targetHeight = targetRect.height

      if (animate) {
        gsap.to(highlightRef.current, {
          left: targetLeft,
          top: targetTop,
          width: targetWidth,
          height: targetHeight,
          duration: 0.5,
          ease: 'power2.out'
        })
      } else {
        gsap.set(highlightRef.current, {
          left: targetLeft,
          top: targetTop,
          width: targetWidth,
          height: targetHeight
        })
      }
    }

    // Initial position without animation - use longer delay to ensure DOM is ready
    const timeoutId = setTimeout(() => {
      if (clareRef.current && highlightRef.current) {
        updateHighlight(clareRef.current, false)
      }
    }, 200)

    return () => clearTimeout(timeoutId)
  }, [])

  // Animate highlight when tab changes
  useEffect(() => {
    if (!highlightRef.current) return

    const targetRef = activeTab === 'CLARE' ? clareRef.current : formanRef.current
    if (!targetRef) return

    const updateHighlight = () => {
      if (!highlightRef.current) return
      
      const targetRect = targetRef.getBoundingClientRect()
      const container = highlightRef.current.offsetParent as HTMLElement
      if (!container) return
      
      const containerRect = container.getBoundingClientRect()

      const targetLeft = targetRect.left - containerRect.left
      const targetTop = targetRect.top - containerRect.top
      const targetWidth = targetRect.width
      const targetHeight = targetRect.height

      gsap.to(highlightRef.current, {
        left: targetLeft,
        top: targetTop,
        width: targetWidth,
        height: targetHeight,
        duration: 0.5,
        ease: 'power2.out'
      })
    }

    // Small delay to ensure layout is complete
    const timeoutId = setTimeout(updateHighlight, 50)
    return () => clearTimeout(timeoutId)
  }, [activeTab])

  return (
    <section id="meet-clare-forman" className={`relative py-20 md:py-32 ${isBuyMode ? 'bg-[#09543D]' : 'bg-[#F9F7F1]'}`}>
      <div className="container mx-auto px-4">
        <div className="flex flex-col lg:flex-row gap-12 lg:gap-24 xl:gap-32 items-start">
          {/* Left Side - Title, Description, Tabs */}
          <div className="lg:w-1/2 w-full">
            {/* Title */}
            <h2 
              className="font-bold mb-4 overflow-hidden relative text-center lg:text-left"
              style={{
                fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                letterSpacing: '-1.3px',
                lineHeight: '0.9',
                color: isBuyMode ? '#FFFFFF' : '#09543D'
              }}
            >
              <span className="block text-5xl md:text-5xl lg:text-6xl">
                MEET{' '}
                <span 
                  ref={clareRef}
                  className="relative inline-block px-2 text-6xl md:text-6xl lg:text-7xl xl:text-8xl z-10"
                  style={{ color: activeTab === 'CLARE' ? '#09543D' : (isBuyMode ? '#FFFFFF' : '#09543D') }}
                >
                  CLARE
                </span>
              </span>
              <span className="block text-6xl md:text-6xl lg:text-7xl xl:text-8xl">
                &{' '}
                <span 
                  ref={formanRef}
                  className="relative inline-block px-2 z-10"
                  style={{ color: activeTab === 'FORMAN' ? '#09543D' : (isBuyMode ? '#FFFFFF' : '#09543D') }}
                >
                  FORMAN
                </span>
              </span>
              
              {/* Animated Highlight */}
              <span
                ref={highlightRef}
                className="absolute bg-[#B8F03F] rounded"
                style={{
                  left: 0,
                  top: 0,
                  width: 0,
                  height: 0,
                  zIndex: 0
                }}
              />
            </h2>

            {/* Description */}
            <p className={`text-base md:text-lg mb-8 text-center lg:text-left ${isBuyMode ? 'text-white' : 'text-gray-700'}`}>
              Your Ai dream team
            </p>

            {/* Tabs */}
            <div className="flex justify-center lg:justify-start">
              <div className="inline-flex bg-white p-2 rounded-full">
              <button
                onClick={() => setActiveTab('CLARE')}
                className={`px-6 py-3 rounded-full font-semibold transition-colors ${
                  activeTab === 'CLARE'
                    ? 'bg-[#09543D] text-white'
                    : 'bg-white text-gray-700'
                }`}
              >
                CLARE
              </button>
              <button
                onClick={() => setActiveTab('FORMAN')}
                className={`px-6 py-3 rounded-full font-semibold transition-colors ${
                  activeTab === 'FORMAN'
                    ? 'bg-[#09543D] text-white'
                    : 'bg-white text-gray-700'
                }`}
              >
                FORMAN
              </button>
              </div>
            </div>
          </div>

          {/* Right Side - Content Grid */}
          <div className="lg:w-1/2 w-full">
            {activeTab === 'CLARE' && (
              <div className="grid grid-cols-1 md:grid-cols-2 gap-y-6 md:gap-y-10 lg:gap-y-12 gap-x-0 md:gap-x-24 lg:gap-x-32 xl:gap-x-40">
                {clareFeatures.map((feature, index) => (
                  <div key={index} className="flex flex-col">
                    <div className="text-2xl md:text-3xl mb-3">{feature.icon}</div>
                    <h3 
                      className="font-bold text-xl md:text-2xl mb-3"
                      style={{ color: isBuyMode ? '#FFFFFF' : '#09543D' }}
                    >
                      {feature.title}
                    </h3>
                    <p className={`text-base md:text-lg leading-relaxed ${isBuyMode ? 'text-white' : 'text-gray-700'}`}>
                      {feature.description}
                    </p>
                  </div>
                ))}
              </div>
            )}

            {activeTab === 'FORMAN' && (
              <div className="grid grid-cols-1 md:grid-cols-2 gap-y-6 md:gap-y-10 lg:gap-y-12 gap-x-0 md:gap-x-24 lg:gap-x-32 xl:gap-x-40">
                {formanFeatures.map((feature, index) => (
                  <div key={index} className="flex flex-col">
                    <div className="text-2xl md:text-3xl mb-3">{feature.icon}</div>
                    <h3 
                      className="font-bold text-xl md:text-2xl mb-3"
                      style={{ color: isBuyMode ? '#FFFFFF' : '#09543D' }}
                    >
                      {feature.title}
                    </h3>
                    <p className={`text-base md:text-lg leading-relaxed ${isBuyMode ? 'text-white' : 'text-gray-700'}`}>
                      {feature.description}
                    </p>
                  </div>
                ))}
              </div>
            )}
          </div>
        </div>
      </div>
    </section>
  )
}

export default MeetClareAndForman


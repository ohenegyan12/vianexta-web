import { useState, useEffect, useRef } from 'react'
import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'
import SplitType from 'split-type'

gsap.registerPlugin(ScrollTrigger)

function FAQ() {
  const [openIndex, setOpenIndex] = useState<number | null>(null)
  const titleRef = useRef<HTMLHeadingElement>(null)

  const faqs = [
    {
      question: 'Curious how we ensure quality?',
      answer: 'We work with certified manufacturers and conduct rigorous quality checks at every stage of production to ensure your products meet the highest standards.'
    },
    {
      question: 'Wondering where your coffee ships from?',
      answer: 'Our products ship from verified warehouses and fulfillment centers strategically located to ensure fast and reliable delivery to your customers.'
    },
    {
      question: 'Want to know where your beans come from?',
      answer: 'We source from ethically certified suppliers who prioritize sustainable farming practices and fair trade relationships.'
    },
    {
      question: 'Need your coffee fast and on time?',
      answer: 'Our streamlined supply chain and logistics network ensure timely delivery. We provide real-time tracking so you always know where your order is.'
    },
    {
      question: 'Where does my order get packed and shipped?',
      answer: 'Orders are packed at our verified fulfillment centers and shipped through our network of trusted logistics partners to ensure safe and efficient delivery.'
    }
  ]

  const toggleFAQ = (index: number) => {
    setOpenIndex(openIndex === index ? null : index)
  }

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

  return (
    <section className="relative bg-[#F9F7F1] py-20 md:py-32">
      <div className="container mx-auto px-4">
        <div className="flex flex-col lg:flex-row gap-12 lg:gap-16 items-start">
          {/* Left Side - Title */}
          <div className="w-full lg:w-1/2 flex flex-col items-center lg:items-start">
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
              <span className="block text-6xl md:text-7xl lg:text-7xl xl:text-8xl">FREQUENTLY</span>
              <span className="block text-6xl md:text-7xl lg:text-7xl xl:text-8xl">ASKED QUESTIONS</span>
            </h2>
          </div>

          {/* Right Side - FAQ Items */}
          <div className="lg:w-1/2">
            <div className="flex flex-col">
              {faqs.map((faq, index) => (
                <div key={index} className="border-b border-gray-300 last:border-b-0">
                  <button
                    onClick={() => toggleFAQ(index)}
                    className="w-full py-4 md:py-6 flex items-center justify-between text-left hover:text-[#09543D] transition-colors"
                  >
                    <span className="text-gray-700 text-base md:text-lg font-medium pr-4">
                      {faq.question}
                    </span>
                    <span 
                      className={`flex-shrink-0 text-gray-400 transition-transform duration-300 ${
                        openIndex === index ? 'rotate-180' : ''
                      }`}
                    >
                      ▼
                    </span>
                  </button>
                  <div
                    className={`overflow-hidden transition-all duration-300 ease-in-out ${
                      openIndex === index ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0'
                    }`}
                  >
                    <div className="pb-4 md:pb-6">
                      <p className="text-gray-600 text-sm md:text-base leading-relaxed">
                        {faq.answer}
                      </p>
                    </div>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>
    </section>
  )
}

export default FAQ


import { useEffect, useRef } from 'react'
import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'
import SplitType from 'split-type'
import gifNormal from '../../assets/gif-normal.mp4'

gsap.registerPlugin(ScrollTrigger)

interface ExperienceClareProps {
  isBuyMode: boolean
}

function ExperienceClare({ isBuyMode }: ExperienceClareProps) {
  const titleRef = useRef<HTMLHeadingElement>(null)

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
    <section 
      className="relative py-20 md:py-32"
      style={{
        background: isBuyMode 
          ? 'linear-gradient(to bottom, #09543D 0%, #09543D 50%, #F9F7F1 50%, #F9F7F1 100%)'
          : '#F9F7F1'
      }}
    >
      <div className="container mx-auto px-4">
        <div className="flex flex-col items-center">
          {/* Title */}
          <h2 
            ref={titleRef}
            className="font-bold mb-8 md:mb-12 text-center overflow-hidden"
            style={{
              fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
              letterSpacing: '-1.3px',
              lineHeight: '0.9',
              color: isBuyMode ? '#FFFFFF' : '#09543D'
            }}
          >
            <span className="block text-5xl md:text-6xl lg:text-7xl xl:text-8xl">
              EXPERIENCE CLARE
            </span>
          </h2>

          {/* Video */}
          <div className="w-full max-w-4xl">
            <video
              src={gifNormal}
              autoPlay
              loop
              muted
              playsInline
              className="w-full h-auto rounded-2xl shadow-lg"
            />
          </div>
        </div>
      </div>
    </section>
  )
}

export default ExperienceClare


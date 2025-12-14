import { useState, useEffect, useMemo } from 'react'
import chatIcon from '../../assets/chat-icon.svg'
import ClareChatModal from './ClareChatModal'

interface SectionInfo {
  id: string
  title: string
  questions: string[]
}

interface ChatButtonProps {
  isBuyMode?: boolean
}

function ChatButton({ isBuyMode = false }: ChatButtonProps) {
  const [isModalOpen, setIsModalOpen] = useState(false)
  const [showWidget, setShowWidget] = useState(true)
  const [currentSection, setCurrentSection] = useState<SectionInfo | null>(null)

  // Define sections and their questions based on actual section content and mode
  const sections: SectionInfo[] = useMemo(() => [
    {
      id: 'hero',
      title: 'Hero Section',
      questions: isBuyMode
        ? [
            'How do I get quality products for my business fast?',
            'How do I find wholesale-ready products?',
            'How do I avoid managing suppliers and inventory chaos?',
            'What products can I sell?'
          ]
        : [
            'How do I build my product in minutes?',
            'How do I launch my product line?',
            'How does ViaNexta build my supply chain?',
            'What is ViaNexta?'
          ]
    },
    {
      id: 'from-idea-to-inventory',
      title: 'From Idea to Inventory',
      questions: isBuyMode
        ? [
            'How do I source trusted products for my business?',
            'How do I find products for cafés, retailers, and hospitality?',
            'How does ViaNexta help me source products consistently?',
            'What products are available for wholesale?'
          ]
        : [
            'How do I go from idea to inventory?',
            'How does ViaNexta guide me through sourcing, branding, and packaging?',
            'What recommendations does Clare provide?',
            'How does the process work from sourcing to shipping?'
          ]
    },
    {
      id: 'chain-builder',
      title: 'Chain Builder',
      questions: [
        'What is the chain builder?',
        'How does the supply chain work?',
        'How do I try the chain builder?',
        'What does the chain builder do?'
      ]
    },
    {
      id: 'meet-clare-forman',
      title: 'Meet Clare & Forman',
      questions: [
        'What is Clare and how does it help with product definition?',
        'What is Forman and how does it handle sourcing?',
        'How do Clare and Forman work together?',
        'What can Clare do for my brand?'
      ]
    },
    {
      id: 'experience-clare',
      title: 'Experience Clare',
      questions: [
        'How do I experience Clare?',
        'What can Clare do for me?',
        'How does Clare work?',
        'Can I see Clare in action?'
      ]
    },
    {
      id: 'trusted-brands',
      title: 'Trusted Brands',
      questions: [
        'Who uses ViaNexta?',
        'What brands trust ViaNexta?',
        'Can I see which companies use ViaNexta?'
      ]
    },
    {
      id: 'hear-from-customers',
      title: 'Hear From Customers',
      questions: [
        'What do customers say about ViaNexta?',
        'Can I read customer testimonials?',
        'What are customer experiences with ViaNexta?'
      ]
    },
    {
      id: 'faq',
      title: 'FAQ',
      questions: [
        'How do you ensure quality?',
        'Where does my coffee ship from?',
        'Where do my beans come from?',
        'How fast can I get my coffee?',
        'Where does my order get packed and shipped?'
      ]
    }
  ], [isBuyMode])

  // Detect current section using Intersection Observer
  useEffect(() => {
    const observers: IntersectionObserver[] = []

    sections.forEach((section) => {
      const element = document.getElementById(section.id)

      if (element) {
        const observer = new IntersectionObserver(
          (entries) => {
            entries.forEach((entry) => {
              if (entry.isIntersecting && entry.intersectionRatio > 0.3) {
                setCurrentSection(section)
              }
            })
          },
          {
            threshold: [0.3, 0.5, 0.7],
            rootMargin: '-20% 0px -20% 0px'
          }
        )
        observer.observe(element)
        observers.push(observer)
      }
    })

    // Fallback: check scroll position
    const handleScroll = () => {
      const scrollPosition = window.scrollY + window.innerHeight / 2

      for (const section of sections) {
        const element = document.getElementById(section.id)
        
        if (element) {
          const rect = element.getBoundingClientRect()
          const elementTop = rect.top + window.scrollY
          const elementBottom = elementTop + rect.height

          if (scrollPosition >= elementTop && scrollPosition <= elementBottom) {
            setCurrentSection(section)
            break
          }
        }
      }
    }

    window.addEventListener('scroll', handleScroll, { passive: true })
    handleScroll() // Check on mount

    return () => {
      observers.forEach(observer => observer.disconnect())
      window.removeEventListener('scroll', handleScroll)
    }
  }, [sections]) // Re-run when sections change (which happens when isBuyMode changes)

  return (
    <>
      <style>
        {`
          @keyframes chat-shake {
            0%, 100% { transform: rotate(0); }
            5% { transform: rotate(12deg); }
            10% { transform: rotate(-12deg); }
            15% { transform: rotate(10deg); }
            20% { transform: rotate(-10deg); }
            25% { transform: rotate(8deg); }
            30% { transform: rotate(-8deg); }
            35% { transform: rotate(4deg); }
            40% { transform: rotate(-4deg); }
            45% { transform: rotate(0); }
          }
          @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
          }
          @keyframes wave {
            0%, 100% { transform: rotate(0deg); }
            10% { transform: rotate(14deg); }
            20% { transform: rotate(-8deg); }
            30% { transform: rotate(14deg); }
            40% { transform: rotate(-4deg); }
            50% { transform: rotate(10deg); }
            60% { transform: rotate(0deg); }
          }
        `}
      </style>

      {/* Info Widget */}
      {showWidget && !isModalOpen && (
        <div
          className="fixed bottom-28 right-8 w-64 bg-white rounded-xl shadow-xl border border-gray-100 p-4 z-40 animate-[fade-in-up_0.5s_ease-out]"
        >
          {/* Close Button */}
          <button
            onClick={(e) => {
              e.stopPropagation()
              setShowWidget(false)
            }}
            className="absolute top-2 right-2 text-gray-400 hover:text-gray-600 transition-colors"
          >
            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>

          {/* Content */}
          <div className="flex flex-col gap-2">
            <h3 className="font-bold text-[#09543D] text-lg">
              Hi, I'm Clare!{' '}
              <span className="inline-block animate-[wave_2s_ease-in-out_infinite]" style={{ transformOrigin: '70% 70%' }}>
                👋
              </span>
            </h3>
            <p className="text-sm text-gray-600 leading-relaxed">
              I'm your personal coffee assistant. I can help you find the perfect beans, track orders, or answer any coffee questions!
            </p>
          </div>

          {/* Arrow pointing down */}
          <div className="absolute -bottom-2 right-6 w-4 h-4 bg-white transform rotate-45 border-r border-b border-gray-100"></div>
        </div>
      )}

      <button
        onClick={() => {
          setIsModalOpen(true)
          setShowWidget(false) // Optionally hide widget when opening chat
        }}
        className="fixed bottom-8 right-8 w-16 h-16 rounded-full bg-[#09543D] flex items-center justify-center shadow-lg hover:shadow-xl transition-all z-50 hover:scale-110"
        style={{ animation: 'chat-shake 5s ease-in-out infinite' }}
        aria-label="Open chat"
      >
        <img src={chatIcon} alt="Chat" className="w-8 h-8" />
      </button>

      <ClareChatModal
        isOpen={isModalOpen}
        onClose={() => setIsModalOpen(false)}
        currentSection={currentSection}
      />
    </>
  )
}

export default ChatButton


import { useState } from 'react'
import chatIcon from '../../assets/chat-icon.svg'
import ClareChatModal from './ClareChatModal'

function ChatButton() {
  const [isModalOpen, setIsModalOpen] = useState(false)
  const [showWidget, setShowWidget] = useState(true)

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
            <h3 className="font-bold text-[#09543D] text-lg">Hi, I'm Clare! 👋</h3>
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
      />
    </>
  )
}

export default ChatButton


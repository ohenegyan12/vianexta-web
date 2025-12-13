import { useState } from 'react'
import chatIcon from '../../assets/chat-icon.svg'
import ClareChatModal from './ClareChatModal'

function ChatButton() {
  const [isModalOpen, setIsModalOpen] = useState(false)

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
        `}
      </style>
      <button
        onClick={() => setIsModalOpen(true)}
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


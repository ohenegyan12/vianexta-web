import { useState } from 'react'
import chatIcon from '../../assets/chat-icon.svg'
import ClareChatModal from './ClareChatModal'

function ChatButton() {
  const [isModalOpen, setIsModalOpen] = useState(false)

  return (
    <>
      <button
        onClick={() => setIsModalOpen(true)}
        className="fixed bottom-8 right-8 w-16 h-16 rounded-full bg-[#09543D] flex items-center justify-center shadow-lg hover:shadow-xl transition-shadow z-50"
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


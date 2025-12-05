import { useState, useRef, useEffect } from 'react'
import vianextaLogo from '../../assets/vianexta-logo.svg'

interface ClareChatModalProps {
  isOpen: boolean
  onClose: () => void
}

function ClareChatModal({ isOpen, onClose }: ClareChatModalProps) {
  const [message, setMessage] = useState('')
  const [messages, setMessages] = useState<Array<{ text: string; isUser: boolean }>>([])
  const inputRef = useRef<HTMLInputElement>(null)
  const messagesEndRef = useRef<HTMLDivElement>(null)

  const quickOptions = [
    "I want to buy coffee",
    "I want to source products",
    "I'm making enquiries",
    "I want to build a brand"
  ]

  useEffect(() => {
    if (isOpen && inputRef.current) {
      inputRef.current.focus()
    }
  }, [isOpen])

  useEffect(() => {
    messagesEndRef.current?.scrollIntoView({ behavior: 'smooth' })
  }, [messages])

  const handleSendMessage = (text?: string) => {
    const messageToSend = text || message.trim()
    if (!messageToSend) return

    setMessages(prev => [...prev, { text: messageToSend, isUser: true }])
    setMessage('')

    // Simulate bot response
    setTimeout(() => {
      setMessages(prev => [...prev, { 
        text: "Thank you for your message! I'm Clare, your AI assistant. How can I help you today?", 
        isUser: false 
      }])
    }, 500)
  }

  const handleQuickOption = (option: string) => {
    handleSendMessage(option)
  }

  const handleKeyPress = (e: React.KeyboardEvent<HTMLInputElement>) => {
    if (e.key === 'Enter') {
      handleSendMessage()
    }
  }

  if (!isOpen) return null

  return (
    <>
      {/* Backdrop */}
      <div 
        className="fixed inset-0 z-[100] bg-black bg-opacity-30 transition-opacity duration-300"
      />

      {/* Chat Modal - Bottom sheet on mobile, positioned above chat button on desktop */}
      <div className="fixed bottom-0 md:bottom-24 right-0 md:right-4 lg:right-8 z-[101] w-full md:w-[calc(100vw-2rem)] lg:w-full lg:max-w-md h-[90vh] md:h-[700px] md:max-h-[calc(90vh-6rem)] max-h-[100dvh] bg-[#F9F7F1] rounded-t-3xl md:rounded-2xl shadow-2xl flex flex-col overflow-hidden animate-slide-up">
        {/* Header */}
        <div className="bg-[#F9F7F1] px-4 py-3 flex items-center justify-between border-b border-gray-300">
          <div className="flex items-center gap-3">
            {/* Logo */}
            <div className="flex items-center gap-2">
              <img src={vianextaLogo} alt="ViaNexta" className="h-6 w-auto" />
              <span 
                className="text-[#09543D] font-bold text-lg"
                style={{
                  fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                }}
              >
                CLARE
              </span>
            </div>
          </div>

          {/* Close Button */}
          <button
            onClick={onClose}
            className="text-[#09543D] hover:opacity-80 transition-opacity"
          >
            <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        {/* Start Conversation Text */}
        <div className="px-4 pt-6 pb-4">
          <p className="text-sm text-gray-600 text-center">
            Start a new conversation with CLARE
          </p>
        </div>

        {/* Messages Area */}
        <div className="flex-1 overflow-y-auto overflow-x-hidden p-4 space-y-4 relative min-h-0">
          {messages.length === 0 ? (
            /* Quick Options - Only show when no messages, positioned at bottom right */
            <div className="absolute bottom-0 right-0 p-4 space-y-3 flex flex-col items-end">
              {quickOptions.map((option, index) => (
                <button
                  key={index}
                  onClick={() => handleQuickOption(option)}
                  className="max-w-[95%] bg-[#09543D] text-white px-4 py-3 rounded-full text-left hover:bg-[#09543D]/90 transition-colors text-sm font-medium whitespace-nowrap"
                >
                  {option}
                </button>
              ))}
            </div>
          ) : (
            /* Chat Messages */
            <div className="space-y-4">
              {messages.map((msg, index) => (
                <div
                  key={index}
                  className={`flex ${msg.isUser ? 'justify-end' : 'justify-start'}`}
                >
                  <div
                    className={`max-w-[80%] px-4 py-2 rounded-2xl ${
                      msg.isUser
                        ? 'bg-[#09543D] text-white'
                        : 'bg-white text-gray-800 border border-gray-200'
                    }`}
                  >
                    <p className="text-sm">{msg.text}</p>
                  </div>
                </div>
              ))}
              <div ref={messagesEndRef} />
            </div>
          )}
        </div>

        {/* Input Area */}
        <div className="p-4 pb-4 md:pb-4 flex-shrink-0">
          <div className="relative">
            <input
              ref={inputRef}
              type="text"
              value={message}
              onChange={(e) => setMessage(e.target.value)}
              onKeyPress={handleKeyPress}
              placeholder="Message..."
              className="w-full px-4 pr-14 py-8 bg-white border border-[#09543D] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#09543D] text-sm"
            />
            <button
              onClick={() => handleSendMessage()}
              disabled={!message.trim()}
              className="absolute right-2 top-1/2 -translate-y-1/2 w-10 h-10 bg-[#09543D] text-white rounded-full flex items-center justify-center hover:bg-[#09543D]/90 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 10l7-7m0 0l7 7m-7-7v18" />
              </svg>
            </button>
          </div>
          
          {/* Privacy Policy */}
          <p className="text-xs text-gray-500 mt-2 text-center">
            By chatting with Clare, you agree to our{' '}
            <a href="#privacy" className="underline font-semibold">Privacy Policy</a>
          </p>
        </div>
      </div>
    </>
  )
}

export default ClareChatModal


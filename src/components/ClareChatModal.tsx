import { useState, useRef, useEffect } from 'react'
import vianextaLogo from '../../assets/vianexta-logo.svg'

interface ClareChatModalProps {
  isOpen: boolean
  onClose: () => void
}

interface Message {
  text: string
  isUser: boolean
  mediaElements?: Array<{
    type: string
    url: string
    altText?: string
    description?: string
  }>
}

const API_BASE_URL = 'https://coffeeplug-api-b982ba0e7659.herokuapp.com'

function ClareChatModal({ isOpen, onClose }: ClareChatModalProps) {
  const [message, setMessage] = useState('')
  const [messages, setMessages] = useState<Message[]>([])
  const [isLoading, setIsLoading] = useState(false)
  const [userId] = useState(() => {
    // Generate or retrieve a persistent userId
    const storedUserId = localStorage.getItem('clare_userId')
    if (storedUserId) return storedUserId
    
    const newUserId = `user_${Date.now()}_${Math.random().toString(36).slice(2, 11)}`
    localStorage.setItem('clare_userId', newUserId)
    return newUserId
  })
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

  const handleSendMessage = async (text?: string) => {
    const messageToSend = text || message.trim()
    if (!messageToSend || isLoading) return

    // Add user message to chat
    setMessages(prev => [...prev, { text: messageToSend, isUser: true }])
    setMessage('')
    setIsLoading(true)

    try {
      const response = await fetch(`${API_BASE_URL}/api/voiceflow/chat`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          userId: userId,
          message: messageToSend
        })
      })

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`)
      }

      const data = await response.json()

      if (data.success && data.data) {
        // Add bot response with formatted text and media elements
        setMessages(prev => [...prev, {
          text: data.data.formattedResponse || data.message || 'I received your message.',
          isUser: false,
          mediaElements: data.data.mediaElements || []
        }])
      } else {
        // Handle error response
        setMessages(prev => [...prev, {
          text: data.error || data.message || 'Sorry, I encountered an error. Please try again.',
          isUser: false
        }])
      }
    } catch (error) {
      console.error('Error sending message:', error)
      setMessages(prev => [...prev, {
        text: 'Sorry, I\'m having trouble connecting. Please try again later.',
        isUser: false
      }])
    } finally {
      setIsLoading(false)
    }
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
      {/* Backdrop - Hidden on mobile, shown on desktop */}
      <div 
        className="hidden md:block fixed inset-0 z-[100] bg-black bg-opacity-30 transition-opacity duration-300"
        onClick={onClose}
      />

      {/* Chat Modal - Full screen on mobile, positioned above chat button on desktop */}
      <div className="fixed inset-0 md:inset-auto md:bottom-24 md:right-4 lg:right-8 z-[101] w-full md:w-[calc(100vw-2rem)] lg:w-full lg:max-w-md h-screen md:h-[700px] md:max-h-[calc(90vh-6rem)] bg-[#F9F7F1] md:rounded-2xl md:shadow-2xl flex flex-col overflow-hidden animate-slide-up">
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

        {/* Start Conversation Text - Only show when no messages */}
        {messages.length === 0 && (
          <div className="px-4 pt-6 pb-4">
            <p className="text-sm text-gray-600 text-center">
              Start a new conversation with CLARE
            </p>
          </div>
        )}

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
                    {msg.isUser ? (
                      <p className="text-sm whitespace-pre-wrap">{msg.text}</p>
                    ) : (
                      <div 
                        className="text-sm clare-chat-html-content"
                        dangerouslySetInnerHTML={{ __html: msg.text }}
                      />
                    )}
                    {/* Render media elements if present */}
                    {msg.mediaElements && msg.mediaElements.length > 0 && (
                      <div className="mt-2 space-y-2">
                        {msg.mediaElements.map((media, mediaIndex) => (
                          <div key={mediaIndex} className="mt-2">
                            {media.type === 'image' && media.url && (
                              <img
                                src={media.url}
                                alt={media.altText || 'Media content'}
                                className="max-w-full rounded-lg"
                              />
                            )}
                            {media.description && (
                              <p className="text-xs mt-1 opacity-80">{media.description}</p>
                            )}
                          </div>
                        ))}
                      </div>
                    )}
                  </div>
                </div>
              ))}
              {/* Loading indicator */}
              {isLoading && (
                <div className="flex justify-start">
                  <div className="max-w-[80%] px-4 py-2 rounded-2xl bg-white text-gray-800 border border-gray-200">
                    <div className="flex items-center gap-2">
                      <div className="flex gap-1">
                        <div className="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style={{ animationDelay: '0ms' }}></div>
                        <div className="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style={{ animationDelay: '150ms' }}></div>
                        <div className="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style={{ animationDelay: '300ms' }}></div>
                      </div>
                      <span className="text-xs text-gray-500">Clare is typing...</span>
                    </div>
                  </div>
                </div>
              )}
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
              placeholder={isLoading ? "Clare is typing..." : "Message..."}
              disabled={isLoading}
              className="w-full px-4 pr-14 py-8 bg-white border border-[#09543D] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#09543D] text-sm disabled:opacity-50 disabled:cursor-not-allowed"
            />
            <button
              onClick={() => handleSendMessage()}
              disabled={!message.trim() || isLoading}
              className="absolute right-2 top-1/2 -translate-y-1/2 w-10 h-10 bg-[#09543D] text-white rounded-full flex items-center justify-center hover:bg-[#09543D]/90 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
            >
              {isLoading ? (
                <svg className="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle>
                  <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
              ) : (
                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 10l7-7m0 0l7 7m-7-7v18" />
                </svg>
              )}
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


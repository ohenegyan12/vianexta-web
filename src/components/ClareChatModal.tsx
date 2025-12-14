import { useState, useRef, useEffect } from 'react'
import vianextaLogo from '../../assets/vianexta-logo.svg'

interface SectionInfo {
  id: string
  title: string
  questions: string[]
}

interface ClareChatModalProps {
  isOpen: boolean
  onClose: () => void
  currentSection?: SectionInfo | null
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

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || 
  (import.meta.env.DEV ? '' : 'https://coffeeplug-api-b982ba0e7659.herokuapp.com')

const CHAT_HISTORY_KEY = 'clare_chat_history'
const MAX_HISTORY_MESSAGES = 100

function ClareChatModal({ isOpen, onClose, currentSection }: ClareChatModalProps) {
  const [message, setMessage] = useState('')
  const [messages, setMessages] = useState<Message[]>([])
  const [isLoading, setIsLoading] = useState(false)
  const [showQuestionCards, setShowQuestionCards] = useState(true)
  const [userId] = useState(() => {
    // Generate or retrieve a persistent userId
    const storedUserId = localStorage.getItem('clare_userId')
    if (storedUserId) return storedUserId

    const newUserId = `user_${Date.now()}_${Math.random().toString(36).slice(2, 11)}`
    localStorage.setItem('clare_userId', newUserId)
    return newUserId
  })
  const inputRef = useRef<HTMLTextAreaElement>(null)
  const messagesEndRef = useRef<HTMLDivElement>(null)

  // Load chat history when modal opens
  useEffect(() => {
    if (isOpen) {
      try {
        const savedHistory = localStorage.getItem(`${CHAT_HISTORY_KEY}_${userId}`)
        if (savedHistory) {
          const parsedHistory = JSON.parse(savedHistory)
          if (Array.isArray(parsedHistory) && parsedHistory.length > 0) {
            setMessages(parsedHistory)
            setShowQuestionCards(false) // Don't show cards if there's history
          } else {
            setShowQuestionCards(true) // Show cards if no history
          }
        } else {
          setShowQuestionCards(true) // Show cards if no history
        }
      } catch (error) {
        console.error('Error loading chat history:', error)
        setShowQuestionCards(true)
      }
    } else {
      // Reset when modal closes
      setShowQuestionCards(true)
    }
  }, [isOpen, userId])

  // Save chat history whenever messages change
  useEffect(() => {
    if (messages.length > 0) {
      try {
        // Keep only last MAX_HISTORY_MESSAGES messages
        const messagesToSave = messages.slice(-MAX_HISTORY_MESSAGES)
        localStorage.setItem(`${CHAT_HISTORY_KEY}_${userId}`, JSON.stringify(messagesToSave))
      } catch (error) {
        console.error('Error saving chat history:', error)
      }
    }
  }, [messages, userId])

  useEffect(() => {
    if (isOpen && inputRef.current) {
      inputRef.current.focus()
      // Reset textarea height when modal opens
      if (inputRef.current) {
        inputRef.current.style.height = 'auto'
        inputRef.current.style.height = `${inputRef.current.scrollHeight}px`
      }
    }
  }, [isOpen])

  // Auto-resize textarea
  useEffect(() => {
    const textarea = inputRef.current
    if (textarea) {
      textarea.style.height = 'auto'
      textarea.style.height = `${textarea.scrollHeight}px`
    }
  }, [message])

  useEffect(() => {
    messagesEndRef.current?.scrollIntoView({ behavior: 'smooth' })
  }, [messages])

  const handleSendMessage = async (text?: string) => {
    const messageToSend = text || message.trim()
    if (!messageToSend || isLoading) return

    // Hide question cards when user sends a message
    if (showQuestionCards) {
      setShowQuestionCards(false)
    }

    // Add user message to chat
    setMessages(prev => [...prev, { text: messageToSend, isUser: true }])
    setMessage('')

    // Reset textarea height
    if (inputRef.current) {
      inputRef.current.style.height = 'auto'
    }

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

  const handleKeyPress = (e: React.KeyboardEvent<HTMLTextAreaElement>) => {
    // On mobile: Enter sends, Shift+Enter creates new line
    // On desktop: Enter sends, Shift+Enter creates new line
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault()
      handleSendMessage()
    }
  }

  const handleInputChange = (e: React.ChangeEvent<HTMLTextAreaElement>) => {
    setMessage(e.target.value)
    // Auto-resize textarea
    const textarea = e.target
    textarea.style.height = 'auto'
    textarea.style.height = `${textarea.scrollHeight}px`
  }

  if (!isOpen) return null

  return (
    <>
      {/* Mobile Backdrop - Only on mobile */}
      <div
        className="lg:hidden fixed inset-0 z-[100] bg-black bg-opacity-50 transition-opacity duration-300"
        onClick={onClose}
      />

      {/* Chat Panel - Fixed on right side, doesn't push content */}
      <div className="fixed top-0 right-0 h-full w-full lg:w-[400px] bg-[#F9F7F1] border-l border-[#09543D] z-[101] flex flex-col shadow-2xl">
        {/* Header */}
        <div className="bg-[#F9F7F1] px-4 py-3 flex items-center justify-between border-b border-[#09543D] flex-shrink-0">
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

        {/* Messages Area */}
        <div className="flex-1 overflow-y-auto overflow-x-hidden p-4 space-y-4 relative min-h-0 flex flex-col">
          {/* Ask Me Anything Header */}
          <div className="text-center mb-4">
            <h2 className="text-2xl md:text-3xl font-bold text-[#09543D]">
              ASK CLARE ANYTHING
            </h2>
          </div>
          
          {/* Question Cards - Show when no messages or when currentSection is available */}
          {showQuestionCards && currentSection && currentSection.questions.length > 0 && (
            <div className="mb-4 flex justify-center items-center w-full">
              <div className="grid grid-cols-1 gap-3 max-w-md mx-auto w-full">
                {currentSection.questions.map((question, index) => (
                  <button
                    key={index}
                    onClick={() => handleSendMessage(question)}
                    className="w-full text-center px-4 py-3 bg-[#09543D] text-white rounded-2xl hover:bg-[#07382F] transition-all duration-200 text-sm font-medium hover:shadow-md"
                  >
                    {question}
                  </button>
                ))}
              </div>
            </div>
          )}

          {messages.length === 0 && !showQuestionCards ? (
            /* Centered welcome message when no messages and no cards */
            <div className="flex-1 flex items-center justify-center">
              <p className="text-sm text-gray-600 text-center">
                Start a new conversation with CLARE
              </p>
            </div>
          ) : messages.length > 0 ? (
            /* Chat Messages */
            <div className="space-y-4">
              {messages.map((msg, index) => (
                <div
                  key={index}
                  className={`flex ${msg.isUser ? 'justify-end' : 'justify-start'}`}
                >
                  <div
                    className={`max-w-[80%] px-4 py-2 rounded-2xl break-words ${msg.isUser
                        ? 'bg-[#09543D] text-white'
                        : 'bg-white text-gray-800 border border-gray-200'
                      }`}
                  >
                    {msg.isUser ? (
                      <p className="text-sm whitespace-pre-wrap break-words overflow-wrap-anywhere leading-relaxed">{msg.text}</p>
                    ) : (
                      <div
                        className="text-sm clare-chat-html-content break-words overflow-wrap-anywhere leading-relaxed"
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
          ) : null}
        </div>

        {/* Input Area */}
        <div className="bg-[#F9F7F1] border-t border-[#09543D] p-4 flex-shrink-0">
          <div className="relative">
            <textarea
              ref={inputRef}
              value={message}
              onChange={handleInputChange}
              onKeyDown={handleKeyPress}
              placeholder={isLoading ? "Clare is typing..." : "Message..."}
              disabled={isLoading}
              rows={1}
              className="w-full px-4 pr-14 py-3 bg-white border border-[#09543D] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#09543D] text-sm disabled:opacity-50 disabled:cursor-not-allowed resize-none overflow-hidden min-h-[48px] max-h-[120px]"
              style={{
                height: 'auto',
                lineHeight: '1.5'
              }}
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
          <p className="text-xs text-[#09543D] mt-2 text-center">
            By chatting with Clare, you agree to our{' '}
            <a href="#privacy" className="underline font-semibold">Privacy Policy</a>
          </p>
        </div>
      </div>
    </>
  )
}

export default ClareChatModal


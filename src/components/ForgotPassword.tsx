import { useState } from 'react'
import { Link } from 'react-router-dom'
import buyLogo from '../../assets/buy-logo.svg'
import ChatButton from './ChatButton'

const API_BASE_URL = 'https://coffeeplug-api-b982ba0e7659.herokuapp.com'

function ForgotPassword() {
  const [email, setEmail] = useState('')
  const [isSubmitted, setIsSubmitted] = useState(false)
  const [isLoading, setIsLoading] = useState(false)
  const [error, setError] = useState<string | null>(null)

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()
    setError(null)
    setIsLoading(true)

    try {
      const response = await fetch(`${API_BASE_URL}/api/request-reset-password`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          email
        })
      })

      const data = await response.json()

      if (!response.ok) {
        throw new Error(data.message || `HTTP error! status: ${response.status}`)
      }

      if (data.statusCode === 200) {
        setIsSubmitted(true)
      } else {
        setError(data.message || 'Password reset request failed. Please try again.')
      }
    } catch (error) {
      console.error('Password reset error:', error)
      setError(error instanceof Error ? error.message : 'An error occurred. Please try again.')
    } finally {
      setIsLoading(false)
    }
  }

  return (
    <div className="min-h-screen flex flex-col bg-white">
      {/* Header - Fixed with background on mobile */}
      <header className="fixed lg:absolute top-0 left-0 right-0 z-50 bg-white lg:bg-transparent border-b border-gray-200 lg:border-none">
        <div className="w-full py-4 px-4 lg:px-12">
          <div className="flex items-center justify-between">
            <Link to="/" className="flex items-center gap-2 z-10 relative">
              <img src={buyLogo} alt="ViaNexta" className="h-8" />
            </Link>
            <div className="flex items-center gap-4 z-10 relative">
              <button className="text-gray-600 hover:text-[#09543D] transition-colors">
                <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
              </button>
              <button className="text-gray-600 hover:text-[#09543D] transition-colors">
                <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </header>

      {/* Main Content - Split Layout */}
      <div className="h-screen flex flex-col lg:flex-row pt-16 lg:pt-0 overflow-hidden">
        {/* Left Section - Marketing Content */}
        <div className="hidden lg:flex lg:w-1/2 bg-[#1E4637] p-12 flex-col justify-center">
          <div className="max-w-md">
            <h1
              className="text-5xl font-bold mb-6 text-white"
              style={{
                fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                letterSpacing: '-1.3px',
                lineHeight: '1.1'
              }}
            >
              Reset Your Password
            </h1>
            <p className="text-lg text-white mb-8 leading-relaxed">
              Don't worry! We'll send you instructions to reset your password and get you back into your account.
            </p>

            {/* Feature Points */}
            <div className="space-y-4 mb-8">
              <div className="flex items-start gap-3">
                <div className="w-6 h-6 rounded-full bg-white flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg className="w-4 h-4 text-[#1E4637]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p className="text-white">Secure password reset process</p>
              </div>
              <div className="flex items-start gap-3">
                <div className="w-6 h-6 rounded-full bg-white flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg className="w-4 h-4 text-[#1E4637]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p className="text-white">Email verification for security</p>
              </div>
              <div className="flex items-start gap-3">
                <div className="w-6 h-6 rounded-full bg-white flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg className="w-4 h-4 text-[#1E4637]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p className="text-white">Quick and easy recovery</p>
              </div>
              <div className="flex items-start gap-3">
                <div className="w-6 h-6 rounded-full bg-white flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg className="w-4 h-4 text-[#1E4637]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p className="text-white">24/7 account support</p>
              </div>
              <div className="flex items-start gap-3">
                <div className="w-6 h-6 rounded-full bg-white flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg className="w-4 h-4 text-[#1E4637]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p className="text-white">Protected account information</p>
              </div>
              <div className="flex items-start gap-3">
                <div className="w-6 h-6 rounded-full bg-white flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg className="w-4 h-4 text-[#1E4637]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p className="text-white">Instant email delivery</p>
              </div>
            </div>

            {/* Additional Info */}
            <div className="mt-8 pt-8 border-t border-white/20">
              <p className="text-white/90 text-sm leading-relaxed">
                Your account security is our priority. We use industry-standard encryption to protect your information.
              </p>
            </div>
          </div>
        </div>

        {/* Right Section - Forgot Password Form */}
        <div className="flex-1 lg:w-1/2 flex flex-col p-8 lg:p-12 bg-white justify-center items-center pt-8 lg:pt-12">
          <div className="w-full max-w-md">
            <h2
              className="text-4xl font-bold mb-2"
              style={{
                fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                color: '#09543D',
                letterSpacing: '-1px'
              }}
            >
              Forgot Password
            </h2>
            <p className="text-gray-600 mb-8">
              Enter your email address and we'll send you a link to reset your password.
            </p>

            {/* Error Message */}
            {error && (
              <div className="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                <p className="text-sm text-red-600">{error}</p>
              </div>
            )}

            {!isSubmitted ? (
              <form onSubmit={handleSubmit} className="space-y-6">
                {/* Email Field */}
                <div>
                  <label htmlFor="email" className="block text-sm font-medium text-gray-700 mb-2">
                    Email
                  </label>
                  <input
                    id="email"
                    type="email"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    placeholder="Enter your email"
                    className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#09543D] focus:border-transparent"
                    required
                    disabled={isLoading}
                  />
                </div>

                {/* Submit Button */}
                <button
                  type="submit"
                  disabled={isLoading}
                  className="w-full bg-[#09543D] text-white py-3 px-6 rounded-xl font-semibold hover:bg-[#09543D]/90 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                >
                  {isLoading ? (
                    <>
                      <svg className="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle>
                        <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                      </svg>
                      Sending...
                    </>
                  ) : (
                    'Send Reset Link'
                  )}
                </button>

                {/* Back to Sign In */}
                <p className="text-center text-sm text-gray-600">
                  Remember your password?{' '}
                  <Link to="/signin" className="text-[#09543D] font-semibold hover:underline">
                    Sign in
                  </Link>
                </p>
              </form>
            ) : (
              <div className="space-y-6">
                {/* Success Message */}
                <div className="bg-green-50 border border-green-200 rounded-xl p-6 text-center">
                  <div className="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg className="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                    </svg>
                  </div>
                  <h3 className="text-lg font-semibold text-gray-900 mb-2">Check your email</h3>
                  <p className="text-sm text-gray-600">
                    We've sent a password reset link to <strong>{email}</strong>
                  </p>
                </div>

                {/* Resend Link */}
                <button
                  onClick={() => setIsSubmitted(false)}
                  className="w-full border border-[#09543D] text-[#09543D] bg-white py-3 px-6 rounded-xl font-semibold hover:bg-[#09543D] hover:text-white transition-colors"
                >
                  Resend Email
                </button>

                {/* Back to Sign In */}
                <p className="text-center text-sm text-gray-600">
                  <Link to="/signin" className="text-[#09543D] font-semibold hover:underline">
                    Back to Sign in
                  </Link>
                </p>
              </div>
            )}

            {/* Terms and Privacy */}
            <p className="mt-8 text-xs text-gray-500 text-center">
              By continuing, you agree to our{' '}
              <a href="#terms" className="text-[#09543D] hover:underline">Terms of service</a>
              {' '}and{' '}
              <a href="#privacy" className="text-[#09543D] hover:underline">Privacy Notice</a>
            </p>
          </div>
        </div>
      </div>

      {/* Chat Button */}
      <ChatButton />
    </div>
  )
}

export default ForgotPassword


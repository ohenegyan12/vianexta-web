import { useState } from 'react'
import { Link } from 'react-router-dom'
import buyLogo from '../../assets/buy-logo.svg'
import ChatButton from './ChatButton'

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || 
  (import.meta.env.DEV ? '' : 'https://coffeeplug-api-b982ba0e7659.herokuapp.com')

function Recommend() {
  const [formData, setFormData] = useState({
    farmerName: '',
    email: '',
    farmerNumber: '',
    recommenderEmail: '',
    farmerDescription: ''
  })
  const [isLoading, setIsLoading] = useState(false)
  const [error, setError] = useState<string | null>(null)
  const [success, setSuccess] = useState(false)

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()
    setError(null)
    setIsLoading(true)

    try {
      // TODO: Replace with actual API endpoint
      const response = await fetch(`${API_BASE_URL}/api/recommend-farmer`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData)
      })

      const data = await response.json()

      if (!response.ok) {
        throw new Error(data.message || 'Failed to submit recommendation')
      }

      setSuccess(true)
      setFormData({
        farmerName: '',
        email: '',
        farmerNumber: '',
        recommenderEmail: '',
        farmerDescription: ''
      })
    } catch (error) {
      console.error('Recommendation error:', error)
      setError(error instanceof Error ? error.message : 'An error occurred. Please try again.')
    } finally {
      setIsLoading(false)
    }
  }

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value
    })
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
              Help Us Grow Our Network
            </h1>
            <p className="text-lg text-white mb-8 leading-relaxed">
              Know an exceptional farmer who would be a great fit for our team? Recommend them to join ViaNexta and help us build a stronger, more connected coffee community.
            </p>

            {/* Feature Points */}
            <div className="space-y-4 mb-8">
              <div className="flex items-start gap-3">
                <div className="w-6 h-6 rounded-full bg-white flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg className="w-4 h-4 text-[#1E4637]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p className="text-white">Connect exceptional farmers with opportunities</p>
              </div>
              <div className="flex items-start gap-3">
                <div className="w-6 h-6 rounded-full bg-white flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg className="w-4 h-4 text-[#1E4637]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p className="text-white">Build a stronger coffee community</p>
              </div>
              <div className="flex items-start gap-3">
                <div className="w-6 h-6 rounded-full bg-white flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg className="w-4 h-4 text-[#1E4637]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p className="text-white">Support sustainable farming practices</p>
              </div>
              <div className="flex items-start gap-3">
                <div className="w-6 h-6 rounded-full bg-white flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg className="w-4 h-4 text-[#1E4637]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p className="text-white">Expand our verified partner network</p>
              </div>
            </div>

            {/* Additional Info */}
            <div className="mt-8 pt-8 border-t border-white/20">
              <p className="text-white/90 text-sm leading-relaxed">
                Your recommendations help us discover talented farmers who share our commitment to quality and sustainability.
              </p>
            </div>
          </div>
        </div>

        {/* Right Section - Recommend Form */}
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
              Recommend
            </h2>
            <p className="text-gray-600 mb-8">
              Recommend a farmer to join our team
            </p>

            {/* Success Message */}
            {success && (
              <div className="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                <p className="text-sm text-green-600">Thank you! Your recommendation has been submitted successfully.</p>
              </div>
            )}

            {/* Error Message */}
            {error && (
              <div className="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                <p className="text-sm text-red-600">{error}</p>
              </div>
            )}

            <form onSubmit={handleSubmit} className="space-y-6">
              {/* Farmers Name and Email - Side by Side */}
              <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label htmlFor="farmerName" className="block text-sm font-medium text-gray-700 mb-2">
                    Farmers Name<span className="text-[#09543D]">*</span>
                  </label>
                  <input
                    id="farmerName"
                    name="farmerName"
                    type="text"
                    value={formData.farmerName}
                    onChange={handleChange}
                    placeholder="Enter farmer's name"
                    className="w-full px-4 py-3 border border-[#09543D] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#09543D] focus:border-transparent"
                    required
                  />
                </div>
                <div>
                  <label htmlFor="email" className="block text-sm font-medium text-gray-700 mb-2">
                    Email<span className="text-[#09543D]">*</span>
                  </label>
                  <input
                    id="email"
                    name="email"
                    type="email"
                    value={formData.email}
                    onChange={handleChange}
                    placeholder="Enter email"
                    className="w-full px-4 py-3 border border-[#09543D] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#09543D] focus:border-transparent"
                    required
                  />
                </div>
              </div>

              {/* Farmers Number and Recommender's Email - Side by Side */}
              <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label htmlFor="farmerNumber" className="block text-sm font-medium text-gray-700 mb-2">
                    Farmers Number<span className="text-[#09543D]">*</span>
                  </label>
                  <input
                    id="farmerNumber"
                    name="farmerNumber"
                    type="tel"
                    value={formData.farmerNumber}
                    onChange={handleChange}
                    placeholder="Enter farmer's number"
                    className="w-full px-4 py-3 border border-[#09543D] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#09543D] focus:border-transparent"
                    required
                  />
                </div>
                <div>
                  <label htmlFor="recommenderEmail" className="block text-sm font-medium text-gray-700 mb-2">
                    Recommender's Email<span className="text-[#09543D]">*</span>
                  </label>
                  <input
                    id="recommenderEmail"
                    name="recommenderEmail"
                    type="email"
                    value={formData.recommenderEmail}
                    onChange={handleChange}
                    placeholder="Enter your email"
                    className="w-full px-4 py-3 border border-[#09543D] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#09543D] focus:border-transparent"
                    required
                  />
                </div>
              </div>

              {/* Farmers Description */}
              <div>
                <label htmlFor="farmerDescription" className="block text-sm font-medium text-gray-700 mb-2">
                  Farmers Description
                </label>
                <textarea
                  id="farmerDescription"
                  name="farmerDescription"
                  value={formData.farmerDescription}
                  onChange={handleChange}
                  placeholder="Tell us about the farmer..."
                  rows={4}
                  className="w-full px-4 py-3 border border-[#09543D] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#09543D] focus:border-transparent resize-none"
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
                    Submitting...
                  </>
                ) : (
                  'Submit'
                )}
              </button>

              {/* Back to Home */}
              <p className="text-center text-sm text-gray-600">
                <Link to="/" className="text-[#09543D] font-semibold hover:underline">
                  ← Back to home
                </Link>
              </p>
            </form>
          </div>
        </div>
      </div>

      {/* Chat Button */}
      <ChatButton />
    </div>
  )
}

export default Recommend







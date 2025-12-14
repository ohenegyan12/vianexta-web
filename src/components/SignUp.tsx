import { useState } from 'react'
import { Link, useNavigate } from 'react-router-dom'
import buyLogo from '../../assets/buy-logo.svg'
import buyerArt from '../../assets/buy-new.svg'
import sellerArt from '../../assets/seller-new.svg'
import roasterArt from '../../assets/roaster-new.svg'
import cafeArt from '../../assets/coffer-owner-new.svg'
import ChatButton from './ChatButton'

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || 'https://coffeeplug-api-b982ba0e7659.herokuapp.com'

function SignUp() {
  const navigate = useNavigate()
  const [currentStep, setCurrentStep] = useState(1)
  const [selectedLanguage, setSelectedLanguage] = useState('')
  const [selectedAccountType, setSelectedAccountType] = useState('')
  const [activeTab, setActiveTab] = useState<'profile' | 'business'>('profile')
  const [showToast, setShowToast] = useState(false)
  const [isLoading, setIsLoading] = useState(false)
  const [error, setError] = useState<string | null>(null)
  const [formData, setFormData] = useState({
    firstName: '',
    lastName: '',
    email: '',
    phone: '',
    password: '',
    confirmPassword: '',
    subscribeNewsletter: false,
    businessName: '',
    businessType: '',
    billingAddressLine1: '',
    billingAddressLine2: '',
    billingCountry: 'Ghana',
    billingState: '',
    billingCity: '',
    billingZipCode: '',
    taxIdNumber: '',
    agreeToTerms: false
  })
  const [showPassword, setShowPassword] = useState(false)
  const [showConfirmPassword, setShowConfirmPassword] = useState(false)
  const totalSteps = 4 // Language, Account Type, Account Details, Verification

  const languages = [
    { code: 'en', name: 'English', flag: '🇺🇸' },
    { code: 'es', name: 'Spanish', flag: '🇪🇸' },
    { code: 'fr', name: 'French', flag: '🇫🇷' },
    { code: 'de', name: 'German', flag: '🇩🇪' },
    { code: 'it', name: 'Italian', flag: '🇮🇹' },
    { code: 'pt', name: 'Portuguese', flag: '🇵🇹' },
    { code: 'zh', name: 'Chinese', flag: '🇨🇳' },
    { code: 'ja', name: 'Japanese', flag: '🇯🇵' },
  ]

  const handleLanguageSelect = (languageCode: string) => {
    setSelectedLanguage(languageCode)
  }

  const handleNext = () => {
    if (currentStep < totalSteps) {
      setCurrentStep(currentStep + 1)
    }
  }

  const handleBack = () => {
    if (currentStep > 1) {
      setCurrentStep(currentStep - 1)
    }
  }

  const handleSignup = async () => {
    // Validate required fields
    if (!formData.firstName || !formData.lastName || !formData.email || !formData.password ||
      !formData.phone || !formData.businessName || !formData.billingAddressLine1 ||
      !formData.billingCity || !formData.billingState || !formData.billingZipCode) {
      setError('Please fill in all required fields.')
      return
    }

    if (formData.password !== formData.confirmPassword) {
      setError('Passwords do not match.')
      return
    }

    if (!formData.agreeToTerms) {
      setError('Please agree to the terms and conditions.')
      return
    }

    setError(null)
    setIsLoading(true)

    try {
      // Map form data to UserInfoDto
      const signupData = {
        email: formData.email,
        password: formData.password,
        userRole: selectedAccountType || 'buyer', // Map account type to userRole
        firstName: formData.firstName,
        lastName: formData.lastName,
        receiveEmailNotifications: formData.subscribeNewsletter,
        phoneNumber: formData.phone,
        businessName: formData.businessName,
        businessType: formData.businessType,
        billingAddressLine1: formData.billingAddressLine1,
        billingAddressLine2: formData.billingAddressLine2 || '',
        billingCity: formData.billingCity,
        billingState: formData.billingState,
        billingCountry: formData.billingCountry,
        billingZipCode: formData.billingZipCode,
        shippingAddressLine1: formData.billingAddressLine1, // Use billing as default
        shippingAddressLine2: formData.billingAddressLine2 || '',
        shippingCity: formData.billingCity,
        shippingState: formData.billingState,
        shippingCountry: formData.billingCountry,
        shippingZipCode: formData.billingZipCode,
        taxIdNumber: formData.taxIdNumber || '',
        preferredLanguage: selectedLanguage || 'en',
        userType: selectedAccountType || 'buyer',
        dateOfAccountCreation: new Date().toISOString()
      }

      const response = await fetch(`${API_BASE_URL}/api/signup`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(signupData)
      })

      const data = await response.json()

      if (!response.ok) {
        throw new Error(data.message || `HTTP error! status: ${response.status}`)
      }

      if (data.statusCode === 200 || data.statusCode === 201) {
        // Show success toast and redirect
        setShowToast(true)
        setTimeout(() => {
          navigate('/signin')
        }, 2000)
      } else {
        setError(data.message || 'Signup failed. Please try again.')
      }
    } catch (error) {
      console.error('Signup error:', error)
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
              Create Your Account
            </h1>
            <p className="text-lg text-white mb-8 leading-relaxed">
              Join ViaNexta and start building your supply chain. Get access to verified suppliers, AI-powered recommendations, and end-to-end logistics.
            </p>

            {/* Feature Points */}
            <div className="space-y-4 mb-8">
              <div className="flex items-start gap-3">
                <div className="w-6 h-6 rounded-full bg-white flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg className="w-4 h-4 text-[#1E4637]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p className="text-white">Quick and easy setup process</p>
              </div>
              <div className="flex items-start gap-3">
                <div className="w-6 h-6 rounded-full bg-white flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg className="w-4 h-4 text-[#1E4637]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p className="text-white">Multi-language support</p>
              </div>
              <div className="flex items-start gap-3">
                <div className="w-6 h-6 rounded-full bg-white flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg className="w-4 h-4 text-[#1E4637]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p className="text-white">Secure account creation</p>
              </div>
              <div className="flex items-start gap-3">
                <div className="w-6 h-6 rounded-full bg-white flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg className="w-4 h-4 text-[#1E4637]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p className="text-white">Instant access to platform</p>
              </div>
              <div className="flex items-start gap-3">
                <div className="w-6 h-6 rounded-full bg-white flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg className="w-4 h-4 text-[#1E4637]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p className="text-white">24/7 customer support</p>
              </div>
              <div className="flex items-start gap-3">
                <div className="w-6 h-6 rounded-full bg-white flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg className="w-4 h-4 text-[#1E4637]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p className="text-white">Free to get started</p>
              </div>
            </div>

            {/* Additional Info */}
            <div className="mt-8 pt-8 border-t border-white/20">
              <p className="text-white/90 text-sm leading-relaxed">
                Join thousands of brands already using ViaNexta to streamline their supply chain operations.
              </p>
            </div>
          </div>
        </div>

        {/* Right Section - Sign Up Form */}
        <div className="flex-1 lg:w-1/2 flex flex-col p-8 lg:p-12 bg-white justify-start lg:justify-center items-center overflow-y-auto pt-8 lg:pt-32">
          <div className="w-full max-w-md">
            {/* Stepper Progress */}
            <div className="mb-8 mt-8">
              <p className="text-sm text-gray-600">
                {currentStep} of {totalSteps}
              </p>
            </div>

            <h2
              className="text-4xl font-bold mb-2"
              style={{
                fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                color: '#09543D',
                letterSpacing: '-1px'
              }}
            >
              {currentStep === 1 && 'Select Language'}
              {currentStep === 2 && 'Choose your account type'}
              {currentStep === 3 && 'Create Account'}
              {currentStep === 4 && 'Verify Email'}
            </h2>
            <p className="text-gray-600 mb-8">
              {currentStep === 1 && 'Choose your preferred language for your ViaNexta experience.'}
              {currentStep === 2 && 'Select the account type that best describes your role.'}
              {currentStep === 3 && 'Enter your details to create your account.'}
              {currentStep === 4 && 'We\'ve sent a verification code to your email.'}
            </p>

            {/* Error Message */}
            {error && (
              <div className="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                <p className="text-sm text-red-600">{error}</p>
              </div>
            )}

            {/* Step 1: Language Selection */}
            {currentStep === 1 && (
              <div className="space-y-4">
                <div className="grid grid-cols-2 gap-3">
                  {languages.map((language) => (
                    <button
                      key={language.code}
                      onClick={() => handleLanguageSelect(language.code)}
                      className={`p-4 rounded-xl border-2 transition-all text-left ${selectedLanguage === language.code
                          ? 'border-[#09543D] bg-[#09543D]/5'
                          : 'border-gray-200 hover:border-gray-300'
                        }`}
                    >
                      <div className="flex items-center gap-3">
                        <span className="text-2xl">{language.flag}</span>
                        <span className="font-medium text-gray-900">{language.name}</span>
                      </div>
                    </button>
                  ))}
                </div>

                <button
                  onClick={handleNext}
                  disabled={!selectedLanguage}
                  className="w-full bg-[#09543D] text-white py-3 px-6 rounded-xl font-semibold hover:bg-[#09543D]/90 transition-colors disabled:opacity-50 disabled:cursor-not-allowed mt-6"
                >
                  Continue
                </button>
              </div>
            )}

            {/* Step 2: Account Type Selection */}
            {currentStep === 2 && (
              <div className="space-y-6">
                <div className="grid grid-cols-2 gap-4">
                  {/* Buyer */}
                  <button
                    onClick={() => setSelectedAccountType('buyer')}
                    className={`p-4 lg:p-6 rounded-xl border-2 transition-all text-center ${selectedAccountType === 'buyer'
                        ? 'border-[#09543D] bg-[#09543D]/5'
                        : 'border-gray-200 hover:border-gray-300'
                      }`}
                  >
                    <div className="w-full h-20 lg:h-32 mx-auto mb-2 lg:mb-3 flex items-center justify-center">
                      <img src={buyerArt} alt="Buyer" className="w-full h-full object-contain" />
                    </div>
                    <div className="flex items-center justify-center mb-2">
                      <span className="font-medium text-gray-900 text-sm lg:text-base">I am a buyer</span>
                    </div>
                  </button>

                  {/* Seller */}
                  <button
                    onClick={() => setSelectedAccountType('seller')}
                    className={`p-4 lg:p-6 rounded-xl border-2 transition-all text-center ${selectedAccountType === 'seller'
                        ? 'border-[#09543D] bg-[#09543D]/5'
                        : 'border-gray-200 hover:border-gray-300'
                      }`}
                  >
                    <div className="w-full h-20 lg:h-32 mx-auto mb-2 lg:mb-3 flex items-center justify-center">
                      <img src={sellerArt} alt="Seller" className="w-full h-full object-contain" />
                    </div>
                    <div className="flex items-center justify-center mb-2">
                      <span className="font-medium text-gray-900 text-sm lg:text-base">I am a seller</span>
                    </div>
                  </button>

                  {/* Roaster */}
                  <button
                    onClick={() => setSelectedAccountType('roaster')}
                    className={`p-4 lg:p-6 rounded-xl border-2 transition-all text-center ${selectedAccountType === 'roaster'
                        ? 'border-[#09543D] bg-[#09543D]/5'
                        : 'border-gray-200 hover:border-gray-300'
                      }`}
                  >
                    <div className="w-full h-20 lg:h-32 mx-auto mb-2 lg:mb-3 flex items-center justify-center">
                      <img src={roasterArt} alt="Roaster" className="w-full h-full object-contain" />
                    </div>
                    <div className="flex items-center justify-center mb-2">
                      <span className="font-medium text-gray-900 text-sm lg:text-base">I am a roaster</span>
                    </div>
                  </button>

                  {/* Cafe Owner */}
                  <button
                    onClick={() => setSelectedAccountType('cafe-owner')}
                    className={`p-4 lg:p-6 rounded-xl border-2 transition-all text-center ${selectedAccountType === 'cafe-owner'
                        ? 'border-[#09543D] bg-[#09543D]/5'
                        : 'border-gray-200 hover:border-gray-300'
                      }`}
                  >
                    <div className="w-full h-20 lg:h-32 mx-auto mb-2 lg:mb-3 flex items-center justify-center">
                      <img src={cafeArt} alt="Cafe Owner" className="w-full h-full object-contain" />
                    </div>
                    <div className="flex items-center justify-center mb-2">
                      <span className="font-medium text-gray-900 text-sm lg:text-base">I am a cafe owner</span>
                    </div>
                  </button>
                </div>

                <div className="flex gap-3 mt-6">
                  <button
                    onClick={handleBack}
                    className="flex-1 border border-gray-300 text-gray-700 py-3 px-6 rounded-xl font-semibold hover:bg-gray-50 transition-colors"
                  >
                    Previous Step
                  </button>
                  <button
                    onClick={handleNext}
                    disabled={!selectedAccountType}
                    className="flex-1 bg-[#09543D] text-white py-3 px-6 rounded-xl font-semibold hover:bg-[#09543D]/90 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                  >
                    Next Step
                  </button>
                </div>
              </div>
            )}

            {/* Step 3: Registration Form with Tabs */}
            {currentStep === 3 && (
              <div className="space-y-4 lg:space-y-6">
                {/* Title */}
                <h3
                  className="text-xl lg:text-2xl font-bold mb-4 lg:mb-6"
                  style={{
                    fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                    color: '#09543D',
                    letterSpacing: '-1px'
                  }}
                >
                  Register
                </h3>

                {/* Tabs */}
                <div className="flex gap-2 mb-6 w-full">
                  <button
                    onClick={() => setActiveTab('profile')}
                    className={`flex-1 px-4 lg:px-6 py-2 rounded-lg font-medium transition-colors text-sm lg:text-base ${activeTab === 'profile'
                        ? 'bg-[#09543D] text-white'
                        : 'bg-gray-200 text-gray-600 hover:bg-gray-300'
                      }`}
                  >
                    Your Profile
                  </button>
                  <button
                    onClick={() => setActiveTab('business')}
                    className={`flex-1 px-4 lg:px-6 py-2 rounded-lg font-medium transition-colors text-sm lg:text-base ${activeTab === 'business'
                        ? 'bg-[#09543D] text-white'
                        : 'bg-gray-200 text-gray-600 hover:bg-gray-300'
                      }`}
                  >
                    Business Information
                  </button>
                </div>

                {/* Profile Tab */}
                {activeTab === 'profile' && (
                  <div className="space-y-6">
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                      {/* Left Column */}
                      <div className="space-y-4">
                        <div>
                          <label className="block text-sm font-medium text-gray-700 mb-2">
                            First Name<span className="text-red-500">*</span>
                          </label>
                          <input
                            type="text"
                            value={formData.firstName}
                            onChange={(e) => setFormData({ ...formData, firstName: e.target.value })}
                            placeholder="Enter your first name"
                            className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#09543D] focus:border-transparent"
                            required
                          />
                        </div>
                        <div>
                          <label className="block text-sm font-medium text-gray-700 mb-2">
                            Email<span className="text-red-500">*</span>
                          </label>
                          <input
                            type="email"
                            value={formData.email}
                            onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                            placeholder="Enter your email"
                            className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#09543D] focus:border-transparent"
                            required
                          />
                        </div>
                        <div>
                          <label className="block text-sm font-medium text-gray-700 mb-2">
                            Password<span className="text-red-500">*</span>
                          </label>
                          <div className="relative">
                            <input
                              type={showPassword ? 'text' : 'password'}
                              value={formData.password}
                              onChange={(e) => setFormData({ ...formData, password: e.target.value })}
                              placeholder="Create a password"
                              className="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#09543D] focus:border-transparent"
                              required
                            />
                            <button
                              type="button"
                              onClick={() => setShowPassword(!showPassword)}
                              className="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
                            >
                              {showPassword ? (
                                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.29 3.29m0 0L3 12.71M6.29 6.29L12.71 12" />
                                </svg>
                              ) : (
                                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                              )}
                            </button>
                          </div>
                        </div>
                      </div>

                      {/* Right Column */}
                      <div className="space-y-4">
                        <div>
                          <label className="block text-sm font-medium text-gray-700 mb-2">
                            Last Name<span className="text-red-500">*</span>
                          </label>
                          <input
                            type="text"
                            value={formData.lastName}
                            onChange={(e) => setFormData({ ...formData, lastName: e.target.value })}
                            placeholder="Enter your last name"
                            className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#09543D] focus:border-transparent"
                            required
                          />
                        </div>
                        <div>
                          <label className="block text-sm font-medium text-gray-700 mb-2">
                            Phone Number<span className="text-red-500">*</span>
                          </label>
                          <input
                            type="tel"
                            value={formData.phone}
                            onChange={(e) => setFormData({ ...formData, phone: e.target.value })}
                            placeholder="Enter your phone number"
                            className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#09543D] focus:border-transparent"
                            required
                          />
                        </div>
                        <div>
                          <label className="block text-sm font-medium text-gray-700 mb-2">
                            Confirm Password<span className="text-red-500">*</span>
                          </label>
                          <div className="relative">
                            <input
                              type={showConfirmPassword ? 'text' : 'password'}
                              value={formData.confirmPassword}
                              onChange={(e) => setFormData({ ...formData, confirmPassword: e.target.value })}
                              placeholder="Confirm your password"
                              className="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#09543D] focus:border-transparent"
                              required
                            />
                            <button
                              type="button"
                              onClick={() => setShowConfirmPassword(!showConfirmPassword)}
                              className="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
                            >
                              {showConfirmPassword ? (
                                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.29 3.29m0 0L3 12.71M6.29 6.29L12.71 12" />
                                </svg>
                              ) : (
                                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                              )}
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>

                    {/* Newsletter Subscription */}
                    <div className="flex items-start gap-3 pt-4">
                      <input
                        type="checkbox"
                        id="newsletter"
                        checked={formData.subscribeNewsletter}
                        onChange={(e) => setFormData({ ...formData, subscribeNewsletter: e.target.checked })}
                        className="mt-1 w-4 h-4 text-[#09543D] border-gray-300 rounded focus:ring-[#09543D]"
                      />
                      <label htmlFor="newsletter" className="text-sm text-gray-700">
                        <span className="font-medium">Subscribe to our newsletter</span>
                        <p className="text-xs text-gray-500 mt-1">
                          Get weekly updates about coffee stories from our farmers and their stock
                        </p>
                      </label>
                    </div>
                  </div>
                )}

                {/* Business Information Tab */}
                {activeTab === 'business' && (
                  <div className="space-y-6">
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                      {/* Left Column */}
                      <div className="space-y-4">
                        <div>
                          <label className="block text-sm font-medium text-gray-700 mb-2">
                            Business Name<span className="text-red-500">*</span>
                          </label>
                          <input
                            type="text"
                            value={formData.businessName}
                            onChange={(e) => setFormData({ ...formData, businessName: e.target.value })}
                            placeholder="Enter your business name"
                            className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#09543D] focus:border-transparent"
                            required
                          />
                        </div>
                        <div>
                          <label className="block text-sm font-medium text-gray-700 mb-2">
                            Billing Address Line 1<span className="text-red-500">*</span>
                          </label>
                          <input
                            type="text"
                            value={formData.billingAddressLine1}
                            onChange={(e) => setFormData({ ...formData, billingAddressLine1: e.target.value })}
                            placeholder="Enter billing address"
                            className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#09543D] focus:border-transparent"
                            required
                          />
                        </div>
                        <div>
                          <label className="block text-sm font-medium text-gray-700 mb-2">
                            Billing Country<span className="text-red-500">*</span>
                          </label>
                          <div className="relative">
                            <select
                              value={formData.billingCountry}
                              onChange={(e) => setFormData({ ...formData, billingCountry: e.target.value })}
                              className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#09543D] focus:border-transparent appearance-none bg-white pr-10"
                              required
                            >
                              <option value="Ghana">Ghana</option>
                              <option value="Nigeria">Nigeria</option>
                              <option value="Kenya">Kenya</option>
                              <option value="Other">Other</option>
                            </select>
                            {formData.billingCountry && (
                              <button
                                type="button"
                                onClick={() => setFormData({ ...formData, billingCountry: '' })}
                                className="absolute right-10 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                              >
                                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                                </svg>
                              </button>
                            )}
                            <div className="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                              <svg className="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                              </svg>
                            </div>
                          </div>
                        </div>
                        <div>
                          <label className="block text-sm font-medium text-gray-700 mb-2">
                            Billing City<span className="text-red-500">*</span>
                          </label>
                          <div className="relative">
                            <select
                              value={formData.billingCity}
                              onChange={(e) => setFormData({ ...formData, billingCity: e.target.value })}
                              className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#09543D] focus:border-transparent appearance-none bg-white pr-10"
                              required
                            >
                              <option value="">Select City</option>
                              <option value="Accra">Accra</option>
                              <option value="Kumasi">Kumasi</option>
                              <option value="Tamale">Tamale</option>
                              <option value="Takoradi">Takoradi</option>
                            </select>
                            <div className="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                              <svg className="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                              </svg>
                            </div>
                          </div>
                        </div>
                      </div>

                      {/* Right Column */}
                      <div className="space-y-4">
                        <div>
                          <label className="block text-sm font-medium text-gray-700 mb-2">
                            Business Type<span className="text-red-500">*</span>
                          </label>
                          <div className="relative">
                            <select
                              value={formData.businessType}
                              onChange={(e) => setFormData({ ...formData, businessType: e.target.value })}
                              className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#09543D] focus:border-transparent appearance-none bg-white pr-10"
                              required
                            >
                              <option value="">Select Business Type</option>
                              <option value="sole-proprietorship">Sole Proprietorship</option>
                              <option value="partnership">Partnership</option>
                              <option value="corporation">Corporation</option>
                              <option value="llc">LLC</option>
                            </select>
                            <div className="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                              <svg className="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                              </svg>
                            </div>
                          </div>
                        </div>
                        <div>
                          <label className="block text-sm font-medium text-gray-700 mb-2">
                            Billing Address Line 2
                          </label>
                          <input
                            type="text"
                            value={formData.billingAddressLine2}
                            onChange={(e) => setFormData({ ...formData, billingAddressLine2: e.target.value })}
                            placeholder="Enter additional address details"
                            className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#09543D] focus:border-transparent"
                          />
                        </div>
                        <div>
                          <label className="block text-sm font-medium text-gray-700 mb-2">
                            State<span className="text-red-500">*</span>
                          </label>
                          <div className="relative">
                            <select
                              value={formData.billingState}
                              onChange={(e) => setFormData({ ...formData, billingState: e.target.value })}
                              className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#09543D] focus:border-transparent appearance-none bg-white pr-10"
                              required
                            >
                              <option value="">Select State/Province</option>
                              <option value="Greater Accra">Greater Accra</option>
                              <option value="Ashanti">Ashanti</option>
                              <option value="Northern">Northern</option>
                              <option value="Western">Western</option>
                              <option value="Eastern">Eastern</option>
                            </select>
                            <div className="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                              <svg className="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                              </svg>
                            </div>
                          </div>
                        </div>
                        <div>
                          <label className="block text-sm font-medium text-gray-700 mb-2">
                            Billing Zip Code<span className="text-red-500">*</span>
                          </label>
                          <input
                            type="text"
                            value={formData.billingZipCode}
                            onChange={(e) => setFormData({ ...formData, billingZipCode: e.target.value })}
                            placeholder="Enter zip code"
                            className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#09543D] focus:border-transparent"
                            required
                          />
                        </div>
                      </div>
                    </div>

                    {/* Tax ID Number - Full Width */}
                    <div className="mt-4">
                      <label className="block text-sm font-medium text-gray-700 mb-2">
                        Tax ID Number
                      </label>
                      <input
                        type="text"
                        value={formData.taxIdNumber}
                        onChange={(e) => setFormData({ ...formData, taxIdNumber: e.target.value })}
                        placeholder="Tax ID Number"
                        className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#09543D] focus:border-transparent"
                      />
                      <p className="text-xs text-gray-500 mt-1">
                        Enter your 9-digit Tax ID (EIN) in format: XX-XXXXXXX (Optional)
                      </p>
                    </div>

                    {/* Terms and Conditions */}
                    <div className="flex items-start gap-3 pt-4">
                      <input
                        type="checkbox"
                        id="terms"
                        checked={formData.agreeToTerms}
                        onChange={(e) => setFormData({ ...formData, agreeToTerms: e.target.checked })}
                        className="mt-1 w-4 h-4 text-[#09543D] border-gray-300 rounded focus:ring-[#09543D]"
                      />
                      <label htmlFor="terms" className="text-sm text-gray-700">
                        I have read and agree to the{' '}
                        <Link to="/terms" className="text-[#09543D] font-semibold hover:underline">
                          ViaNexta EULA
                        </Link>{' '}
                        and{' '}
                        <Link to="/privacy" className="text-[#09543D] font-semibold hover:underline">
                          Privacy Policy
                        </Link>
                      </label>
                    </div>
                  </div>
                )}

                {/* Navigation Buttons */}
                <div className="flex gap-3 pt-6">
                  <button
                    onClick={handleBack}
                    className="flex-1 border border-gray-300 text-gray-700 py-3 px-6 rounded-xl font-semibold hover:bg-gray-50 transition-colors"
                  >
                    Previous Step
                  </button>
                  <button
                    onClick={async () => {
                      if (activeTab === 'profile') {
                        setActiveTab('business')
                      } else {
                        // Handle finish - submit signup
                        await handleSignup()
                      }
                    }}
                    disabled={isLoading}
                    className="flex-1 bg-[#09543D] text-white py-3 px-6 rounded-xl font-semibold hover:bg-[#09543D]/90 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                  >
                    {isLoading ? (
                      <>
                        <svg className="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                          <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle>
                          <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Creating account...
                      </>
                    ) : (
                      activeTab === 'profile' ? 'Next: Business Info' : 'Finish'
                    )}
                  </button>
                </div>
              </div>
            )}

            {/* Step 4: Verification */}
            {currentStep === 4 && (
              <div className="space-y-6">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">
                    Verification Code
                  </label>
                  <input
                    type="text"
                    placeholder="Enter 6-digit code"
                    className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#09543D] focus:border-transparent text-center text-2xl tracking-widest"
                    maxLength={6}
                  />
                </div>
                <p className="text-sm text-gray-600 text-center">
                  Didn't receive the code?{' '}
                  <button className="text-[#09543D] font-semibold hover:underline">
                    Resend
                  </button>
                </p>

                <div className="flex gap-3">
                  <button
                    onClick={handleBack}
                    className="flex-1 border border-gray-300 text-gray-700 py-3 px-6 rounded-xl font-semibold hover:bg-gray-50 transition-colors"
                  >
                    Back
                  </button>
                  <button
                    onClick={() => {
                      // Handle verification
                      console.log('Account created!')
                    }}
                    className="flex-1 bg-[#09543D] text-white py-3 px-6 rounded-xl font-semibold hover:bg-[#09543D]/90 transition-colors"
                  >
                    Verify & Create Account
                  </button>
                </div>
              </div>
            )}

            {/* Sign In Link */}
            <p className="mt-8 text-center text-sm text-gray-600">
              Already have an account?{' '}
              <Link to="/signin" className="text-[#09543D] font-semibold hover:underline">
                Sign in
              </Link>
            </p>

            {/* Terms and Privacy */}
            <p className="mt-6 text-xs text-gray-500 text-center">
              By creating an account, you agree to our{' '}
              <Link to="/terms" className="text-[#09543D] hover:underline">Terms of service</Link>
              {' '}and{' '}
              <Link to="/privacy" className="text-[#09543D] hover:underline">Privacy Notice</Link>
            </p>
          </div>
        </div>
      </div>

      {/* Toast Notification */}
      {showToast && (
        <div className="fixed top-4 right-4 bg-[#09543D] text-white px-6 py-4 rounded-lg shadow-lg z-50 animate-slide-down">
          <div className="flex items-center gap-3">
            <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
            </svg>
            <span className="font-semibold">Registration successful!</span>
          </div>
        </div>
      )}

      {/* Chat Button */}
      <ChatButton />
    </div>
  )
}

export default SignUp


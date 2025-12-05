import { useState, useRef, useEffect } from 'react'
import { Link, useNavigate } from 'react-router-dom'
import buyLogo from '../../assets/buy-logo.svg'
import roastedIcon from '../../assets/roasted.svg'
import wholesaleBrandsIcon from '../../assets/wholesale-brands.svg'
import singleOriginIcon from '../../assets/single-origin.svg'
import blendIcon from '../../assets/blend.svg'
import lightRoastIcon from '../../assets/light.svg'
import mediumRoastIcon from '../../assets/medium.svg'
import mediumDarkRoastIcon from '../../assets/medium-dark.svg'
import darkRoastIcon from '../../assets/dark.svg'
import ChatButton from './ChatButton'

function BuyerWizard() {
  const navigate = useNavigate()
  const [selectedType, setSelectedType] = useState<string>('')
  const [selectedCoffeeType, setSelectedCoffeeType] = useState<string>('')
  const [selectedCoffee, setSelectedCoffee] = useState<string>('')
  const [selectedProduct, setSelectedProduct] = useState<string>('')
  const [selectedWholesaleProduct, setSelectedWholesaleProduct] = useState<string>('')
  const [selectedRoastType, setSelectedRoastType] = useState<string>('')
  const [selectedGrindType, setSelectedGrindType] = useState<string>('')
  const [selectedPackageSize, setSelectedPackageSize] = useState<string>('')
  const [bagSize, setBagSize] = useState<string>('12oz Retail Bag')
  const [bagPrice, setBagPrice] = useState<string>('19')
  const [caseQuantity, setCaseQuantity] = useState<string>('1')
  const [amount, setAmount] = useState<string>('19')
  const [quantity, setQuantity] = useState<string>('')
  const [uploadedLogo, setUploadedLogo] = useState<File | null>(null)
  const [logoPreview, setLogoPreview] = useState<string>('')
  const [showNotification, setShowNotification] = useState(false)
  const [showLogoutConfirm, setShowLogoutConfirm] = useState(false)
  const [isLoading, setIsLoading] = useState(false)
  const [currentPage, setCurrentPage] = useState(1)
  const [wholesalePage, setWholesalePage] = useState(1)
  const [showCoffeeType, setShowCoffeeType] = useState(false)
  const [showSingleOrigin, setShowSingleOrigin] = useState(false)
  const [showProductSelection, setShowProductSelection] = useState(false)
  const [showWholesaleBrands, setShowWholesaleBrands] = useState(false)
  const [showRoastType, setShowRoastType] = useState(false)
  const [showGrindType, setShowGrindType] = useState(false)
  const [showPackageSize, setShowPackageSize] = useState(false)
  const totalPages = 3
  const wholesaleTotalPages = 2
  const coffeeTypeSectionRef = useRef<HTMLDivElement>(null)
  const singleOriginSectionRef = useRef<HTMLDivElement>(null)
  const productSelectionSectionRef = useRef<HTMLDivElement>(null)
  const wholesaleBrandsSectionRef = useRef<HTMLDivElement>(null)
  const roastTypeSectionRef = useRef<HTMLDivElement>(null)
  const grindTypeSectionRef = useRef<HTMLDivElement>(null)
  const packageSizeSectionRef = useRef<HTMLDivElement>(null)
  const dropzoneSectionRef = useRef<HTMLLabelElement>(null)
  const wholesaleProductDetailRef = useRef<HTMLDivElement>(null)

  useEffect(() => {
    if (selectedType === 'roasted') {
      setTimeout(() => setShowCoffeeType(true), 50)
    } else if (selectedType === 'wholesale') {
      setTimeout(() => setShowWholesaleBrands(true), 50)
      // Scroll to wholesale brands section after it's rendered
      setTimeout(() => {
        if (wholesaleBrandsSectionRef.current) {
          const scrollContainer = wholesaleBrandsSectionRef.current.closest('.overflow-y-auto') as HTMLElement
          if (scrollContainer) {
            const elementRect = wholesaleBrandsSectionRef.current.getBoundingClientRect()
            const containerRect = scrollContainer.getBoundingClientRect()
            const offset = 120
            const scrollTop = scrollContainer.scrollTop + (elementRect.top - containerRect.top) - offset
            
            scrollContainer.scrollTo({
              top: Math.max(0, scrollTop),
              behavior: 'smooth'
            })
          } else {
            wholesaleBrandsSectionRef.current.scrollIntoView({ behavior: 'smooth', block: 'center' })
          }
        }
      }, 600)
    } else {
      setShowCoffeeType(false)
      setShowSingleOrigin(false)
      setShowWholesaleBrands(false)
    }
  }, [selectedType])

  useEffect(() => {
    if (selectedCoffeeType === 'single-origin') {
      setTimeout(() => setShowSingleOrigin(true), 50)
    } else if (selectedCoffeeType === 'blend') {
      setTimeout(() => setShowProductSelection(true), 50)
      // Scroll to product selection section after it's rendered
      setTimeout(() => {
        if (productSelectionSectionRef.current) {
          const scrollContainer = productSelectionSectionRef.current.closest('.overflow-y-auto') as HTMLElement
          if (scrollContainer) {
            const elementRect = productSelectionSectionRef.current.getBoundingClientRect()
            const containerRect = scrollContainer.getBoundingClientRect()
            const offset = 120
            const scrollTop = scrollContainer.scrollTop + (elementRect.top - containerRect.top) - offset
            
            scrollContainer.scrollTo({
              top: Math.max(0, scrollTop),
              behavior: 'smooth'
            })
          } else {
            productSelectionSectionRef.current.scrollIntoView({ behavior: 'smooth', block: 'center' })
          }
        }
      }, 600)
    } else {
      setShowSingleOrigin(false)
      setShowProductSelection(false)
      setShowRoastType(false)
      setSelectedCoffee('')
      setSelectedProduct('')
      setSelectedRoastType('')
    }
  }, [selectedCoffeeType])

  useEffect(() => {
    if (selectedProduct) {
      setTimeout(() => setShowRoastType(true), 50)
      // Scroll to roast type section after it's rendered and animated
      setTimeout(() => {
        if (roastTypeSectionRef.current) {
          // Get the scrollable parent container
          const scrollContainer = roastTypeSectionRef.current.closest('.overflow-y-auto') as HTMLElement
          if (scrollContainer) {
            const elementRect = roastTypeSectionRef.current.getBoundingClientRect()
            const containerRect = scrollContainer.getBoundingClientRect()
            const offset = 120 // Offset from top of container
            const scrollTop = scrollContainer.scrollTop + (elementRect.top - containerRect.top) - offset
            
            scrollContainer.scrollTo({
              top: Math.max(0, scrollTop),
              behavior: 'smooth'
            })
          } else {
            roastTypeSectionRef.current.scrollIntoView({ behavior: 'smooth', block: 'center' })
          }
        }
      }, 600)
    } else {
      setShowRoastType(false)
      setSelectedRoastType('')
      setShowGrindType(false)
      setSelectedGrindType('')
      setShowPackageSize(false)
      setSelectedPackageSize('')
    }
  }, [selectedProduct])

  useEffect(() => {
    if (selectedCoffee) {
      setTimeout(() => setShowRoastType(true), 50)
      // Scroll to roast type section after it's rendered and animated
      setTimeout(() => {
        if (roastTypeSectionRef.current) {
          // Get the scrollable parent container
          const scrollContainer = roastTypeSectionRef.current.closest('.overflow-y-auto') as HTMLElement
          if (scrollContainer) {
            const elementRect = roastTypeSectionRef.current.getBoundingClientRect()
            const containerRect = scrollContainer.getBoundingClientRect()
            const offset = 120 // Offset from top of container
            const scrollTop = scrollContainer.scrollTop + (elementRect.top - containerRect.top) - offset
            
            scrollContainer.scrollTo({
              top: Math.max(0, scrollTop),
              behavior: 'smooth'
            })
          } else {
            roastTypeSectionRef.current.scrollIntoView({ behavior: 'smooth', block: 'center' })
          }
        }
      }, 600)
    } else {
      setShowRoastType(false)
      setSelectedRoastType('')
      setShowGrindType(false)
      setSelectedGrindType('')
    }
  }, [selectedCoffee])

  useEffect(() => {
    if (selectedRoastType) {
      setTimeout(() => setShowGrindType(true), 50)
      // Scroll to grind type section after it's rendered and animated
      setTimeout(() => {
        if (grindTypeSectionRef.current) {
          // Get the scrollable parent container
          const scrollContainer = grindTypeSectionRef.current.closest('.overflow-y-auto') as HTMLElement
          if (scrollContainer) {
            const elementRect = grindTypeSectionRef.current.getBoundingClientRect()
            const containerRect = scrollContainer.getBoundingClientRect()
            const offset = 120 // Offset from top of container
            const scrollTop = scrollContainer.scrollTop + (elementRect.top - containerRect.top) - offset
            
            scrollContainer.scrollTo({
              top: Math.max(0, scrollTop),
              behavior: 'smooth'
            })
          } else {
            grindTypeSectionRef.current.scrollIntoView({ behavior: 'smooth', block: 'center' })
          }
        }
      }, 600)
    } else {
      setShowGrindType(false)
      setSelectedGrindType('')
      setShowPackageSize(false)
      setSelectedPackageSize('')
    }
  }, [selectedRoastType])

  useEffect(() => {
    if (selectedGrindType) {
      setTimeout(() => setShowPackageSize(true), 50)
      // Scroll to package size section after it's rendered and animated
      setTimeout(() => {
        if (packageSizeSectionRef.current) {
          // Get the scrollable parent container
          const scrollContainer = packageSizeSectionRef.current.closest('.overflow-y-auto') as HTMLElement
          if (scrollContainer) {
            const elementRect = packageSizeSectionRef.current.getBoundingClientRect()
            const containerRect = scrollContainer.getBoundingClientRect()
            const offset = 120 // Offset from top of container
            const scrollTop = scrollContainer.scrollTop + (elementRect.top - containerRect.top) - offset
            
            scrollContainer.scrollTo({
              top: Math.max(0, scrollTop),
              behavior: 'smooth'
            })
          } else {
            packageSizeSectionRef.current.scrollIntoView({ behavior: 'smooth', block: 'center' })
          }
        }
      }, 600)
    } else {
      setShowPackageSize(false)
      setSelectedPackageSize('')
    }
  }, [selectedGrindType])

  useEffect(() => {
    if (selectedPackageSize) {
      // Scroll to dropzone section after it's rendered
      setTimeout(() => {
        if (dropzoneSectionRef.current) {
          // Get the scrollable parent container
          const scrollContainer = dropzoneSectionRef.current.closest('.overflow-y-auto') as HTMLElement
          if (scrollContainer) {
            const elementRect = dropzoneSectionRef.current.getBoundingClientRect()
            const containerRect = scrollContainer.getBoundingClientRect()
            const offset = 120 // Offset from top of container
            const scrollTop = scrollContainer.scrollTop + (elementRect.top - containerRect.top) - offset
            
            scrollContainer.scrollTo({
              top: Math.max(0, scrollTop),
              behavior: 'smooth'
            })
          } else {
            dropzoneSectionRef.current.scrollIntoView({ behavior: 'smooth', block: 'center' })
          }
        }
      }, 300)
    }
  }, [selectedPackageSize])

  useEffect(() => {
    if (selectedWholesaleProduct) {
      // Scroll to product detail view after it's rendered
      setTimeout(() => {
        if (wholesaleProductDetailRef.current) {
          // Get the scrollable parent container
          const scrollContainer = wholesaleProductDetailRef.current.closest('.overflow-y-auto') as HTMLElement
          if (scrollContainer) {
            const elementRect = wholesaleProductDetailRef.current.getBoundingClientRect()
            const containerRect = scrollContainer.getBoundingClientRect()
            const offset = 120 // Offset from top of container
            const scrollTop = scrollContainer.scrollTop + (elementRect.top - containerRect.top) - offset
            
            scrollContainer.scrollTo({
              top: Math.max(0, scrollTop),
              behavior: 'smooth'
            })
          } else {
            wholesaleProductDetailRef.current.scrollIntoView({ behavior: 'smooth', block: 'center' })
          }
        }
      }, 100)
    }
  }, [selectedWholesaleProduct])

  const handleLogoUpload = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0]
    if (file) {
      setUploadedLogo(file)
      const reader = new FileReader()
      reader.onloadend = () => {
        setLogoPreview(reader.result as string)
      }
      reader.readAsDataURL(file)
    }
  }

  const packageSizes = [
    { id: '5lb', name: '5lb Bag', details: { size: '~6" W x 4" D x 14" H', color: 'Matte black', labelSize: '2.5 in (H) x 4.5 in (L)' } },
    { id: '12oz', name: '12oz Bag', details: { size: '~4" W x 3" D x 12" H', color: 'Matte black', labelSize: '1.75 in (H) x 3.75 in (L)' } },
    { id: '10oz', name: '10oz Bag', details: { size: '~3.5" W x 2.5" D x 10" H', color: 'Matte black', labelSize: '1.5 in (H) x 3.25 in (L)' } },
    { id: 'frac', name: 'Frac Packs', details: { size: '~2" W x 1.5" D x 4" H', color: 'Matte black', labelSize: '1 in (H) x 2 in (L)' } },
    { id: 'kcup', name: 'K Cup', details: { size: '~2" W x 2" D x 1.5" H', color: 'Matte black', labelSize: '1.5 in (H) x 1.5 in (L)' } },
  ]

  const selectedPackage = packageSizes.find(p => p.id === selectedPackageSize)

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
              {/* User name */}
              <div className="bg-gradient-to-r from-[#09543D] to-[#0d6b4f] rounded-full px-5 py-2.5 shadow-md hover:shadow-lg transition-all duration-200">
                <span 
                  className="text-white font-bold text-sm lg:text-base tracking-tight"
                  style={{
                    fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                  }}
                >
                  Ohene Gyan
                </span>
              </div>

              {/* Dashboard icon */}
              <button 
                className="w-11 h-11 lg:w-12 lg:h-12 rounded-full bg-white border-2 border-gray-100 flex items-center justify-center hover:border-[#09543D] hover:bg-[#09543D]/5 transition-all duration-200 shadow-sm hover:shadow-md group"
                aria-label="Dashboard"
              >
                <svg className="w-5 h-5 lg:w-6 lg:h-6 text-gray-600 group-hover:text-[#09543D] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
              </button>

              {/* Order history icon */}
              <button 
                className="w-11 h-11 lg:w-12 lg:h-12 rounded-full bg-white border-2 border-gray-100 flex items-center justify-center hover:border-[#09543D] hover:bg-[#09543D]/5 transition-all duration-200 shadow-sm hover:shadow-md group"
                aria-label="Order History"
              >
                <svg className="w-5 h-5 lg:w-6 lg:h-6 text-gray-600 group-hover:text-[#09543D] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
              </button>

              {/* Logout icon */}
              <button 
                onClick={() => setShowLogoutConfirm(true)}
                className="w-11 h-11 lg:w-12 lg:h-12 rounded-full bg-white border-2 border-gray-100 flex items-center justify-center hover:border-red-400 hover:bg-red-50 transition-all duration-200 shadow-sm hover:shadow-md group"
                aria-label="Logout"
              >
                <svg className="w-5 h-5 lg:w-6 lg:h-6 text-gray-600 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </header>

      {/* Main Content - Split Layout */}
      <div className="h-screen flex flex-col lg:flex-row pt-16 lg:pt-0 overflow-hidden">
        {/* Left Section - Marketing Content */}
        <div className="hidden lg:flex lg:w-1/5 bg-[#1E4637] p-12 pt-24 flex-col justify-start overflow-y-auto">
          <div className="max-w-md">
            <h1 
              className="text-5xl font-bold mb-6 text-white"
              style={{
                fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                letterSpacing: '-1.3px',
                lineHeight: '1.1'
              }}
            >
              Find Your Perfect Coffee
            </h1>
            <p className="text-lg text-white mb-8 leading-relaxed">
              Browse through our curated selection of premium coffee beans. From single origin to custom blends, discover the perfect coffee for your business.
            </p>
            
            {/* Feature Points */}
            <div className="space-y-4 mb-8">
              <div className="flex items-start gap-3">
                <div className="w-6 h-6 rounded-full bg-white flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg className="w-4 h-4 text-[#1E4637]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p className="text-white">Premium quality coffee beans</p>
              </div>
              <div className="flex items-start gap-3">
                <div className="w-6 h-6 rounded-full bg-white flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg className="w-4 h-4 text-[#1E4637]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p className="text-white">Direct from verified farmers</p>
              </div>
              <div className="flex items-start gap-3">
                <div className="w-6 h-6 rounded-full bg-white flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg className="w-4 h-4 text-[#1E4637]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p className="text-white">Competitive wholesale pricing</p>
              </div>
              <div className="flex items-start gap-3">
                <div className="w-6 h-6 rounded-full bg-white flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg className="w-4 h-4 text-[#1E4637]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p className="text-white">Fast and reliable delivery</p>
              </div>
            </div>

            {/* Additional Info */}
            <div className="mt-8 pt-8 border-t border-white/20">
              <p className="text-white/90 text-sm leading-relaxed">
                Join thousands of businesses sourcing premium coffee through ViaNexta's trusted marketplace.
              </p>
            </div>
          </div>
        </div>

        {/* Right Section - Wizard Content */}
        <div className="flex-1 lg:w-4/5 flex flex-col p-8 lg:p-12 bg-white justify-start items-center overflow-y-auto pt-8 lg:pt-24 relative">
          <div className="w-full max-w-6xl">
            {/* Question */}
            <div className="text-center mb-6 lg:mb-8">
              <h1 
                className="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-bold text-gray-900 mb-3 leading-tight"
                style={{
                  fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                  letterSpacing: '-1.5px',
                  lineHeight: '1.1'
                }}
              >
                What type of coffee bean
              </h1>
              <h1 
                className="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-bold text-[#09543D] leading-tight"
                style={{
                  fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                  letterSpacing: '-1.5px',
                  lineHeight: '1.1'
                }}
              >
                are you looking for?
              </h1>
            </div>

            {/* Cards */}
            <div className="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-5 max-w-lg mx-auto mb-6">
              {/* Roasted Card */}
              <button
                onClick={() => {
                  setSelectedType('roasted')
                  setTimeout(() => {
                    coffeeTypeSectionRef.current?.scrollIntoView({ behavior: 'smooth', block: 'start' })
                  }, 100)
                }}
                className={`group relative bg-white rounded-xl border-2 p-4 lg:p-5 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${
                  selectedType === 'roasted'
                    ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                    : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-lg'
                }`}
              >
                {/* Selection indicator */}
                {selectedType === 'roasted' && (
                  <div className="absolute top-2 right-2 w-4 h-4 bg-[#09543D] rounded-full flex items-center justify-center">
                    <svg className="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3} d="M5 13l4 4L19 7" />
                    </svg>
                  </div>
                )}
                
                <div className="flex justify-center mb-3 lg:mb-4">
                  <img src={roastedIcon} alt="Roasted" className="w-16 h-16 lg:w-20 lg:h-20 object-contain transition-transform duration-300 group-hover:scale-110" />
                </div>
                <h3 
                  className={`text-base lg:text-lg font-bold transition-colors ${
                    selectedType === 'roasted' ? 'text-[#09543D]' : 'text-gray-800'
                  }`}
                  style={{
                    fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                    letterSpacing: '-0.5px'
                  }}
                >
                  Roasted
                </h3>
              </button>

              {/* Wholesale Brands Card */}
              <button
                onClick={() => setSelectedType('wholesale')}
                className={`group relative bg-white rounded-xl border-2 p-4 lg:p-5 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${
                  selectedType === 'wholesale'
                    ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                    : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-lg'
                }`}
              >
                {/* Selection indicator */}
                {selectedType === 'wholesale' && (
                  <div className="absolute top-2 right-2 w-4 h-4 bg-[#09543D] rounded-full flex items-center justify-center">
                    <svg className="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3} d="M5 13l4 4L19 7" />
                    </svg>
                  </div>
                )}
                
                <div className="flex justify-center mb-3 lg:mb-4">
                  <img src={wholesaleBrandsIcon} alt="Wholesale Brands" className="w-16 h-16 lg:w-20 lg:h-20 object-contain transition-transform duration-300 group-hover:scale-110" />
                </div>
                <h3 
                  className={`text-base lg:text-lg font-bold transition-colors ${
                    selectedType === 'wholesale' ? 'text-[#09543D]' : 'text-gray-800'
                  }`}
                  style={{
                    fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                    letterSpacing: '-0.5px'
                  }}
                >
                  Wholesale Brands
                </h3>
              </button>
            </div>

            {/* Second Question - How do you want your coffee? */}
            {selectedType === 'roasted' && (
              <div 
                ref={coffeeTypeSectionRef} 
                className={`mt-8 lg:mt-10 transition-all duration-500 ${
                  showCoffeeType ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'
                }`}
              >
                <h2 
                  className="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 text-center mb-6 lg:mb-8"
                  style={{
                    fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                    letterSpacing: '-1.5px',
                    lineHeight: '1.1'
                  }}
                >
                  How do you want your coffee?
                </h2>

                {/* Cards */}
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-5 max-w-lg mx-auto">
                  {/* Single Origin Card */}
                  <button
                    onClick={() => {
                      setSelectedCoffeeType('single-origin')
                      setTimeout(() => {
                        singleOriginSectionRef.current?.scrollIntoView({ behavior: 'smooth', block: 'start' })
                      }, 100)
                    }}
                    className={`group relative bg-white rounded-xl border-2 p-4 lg:p-5 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${
                      selectedCoffeeType === 'single-origin'
                        ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                        : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-lg'
                    }`}
                  >
                    {/* Selection indicator */}
                    {selectedCoffeeType === 'single-origin' && (
                      <div className="absolute top-2 right-2 w-4 h-4 bg-[#09543D] rounded-full flex items-center justify-center">
                        <svg className="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3} d="M5 13l4 4L19 7" />
                        </svg>
                      </div>
                    )}
                    
                    <div className="flex justify-center mb-3 lg:mb-4">
                      <img src={singleOriginIcon} alt="Single Origin" className="w-16 h-16 lg:w-20 lg:h-20 object-contain transition-transform duration-300 group-hover:scale-110" />
                    </div>
                    <h3 
                      className={`text-base lg:text-lg font-bold transition-colors ${
                        selectedCoffeeType === 'single-origin' ? 'text-[#09543D]' : 'text-gray-800'
                      }`}
                      style={{
                        fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                        letterSpacing: '-0.5px'
                      }}
                    >
                      Single Origin
                    </h3>
                  </button>

                  {/* Blend Card */}
                  <button
                    onClick={() => {
                      setSelectedCoffeeType('blend')
                      setTimeout(() => {
                        productSelectionSectionRef.current?.scrollIntoView({ behavior: 'smooth', block: 'start' })
                      }, 100)
                    }}
                    className={`group relative bg-white rounded-xl border-2 p-4 lg:p-5 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${
                      selectedCoffeeType === 'blend'
                        ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                        : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-lg'
                    }`}
                  >
                    {/* Selection indicator */}
                    {selectedCoffeeType === 'blend' && (
                      <div className="absolute top-2 right-2 w-4 h-4 bg-[#09543D] rounded-full flex items-center justify-center">
                        <svg className="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3} d="M5 13l4 4L19 7" />
                        </svg>
                      </div>
                    )}
                    
                    <div className="flex justify-center mb-3 lg:mb-4">
                      <img src={blendIcon} alt="Blend" className="w-16 h-16 lg:w-20 lg:h-20 object-contain transition-transform duration-300 group-hover:scale-110" />
                    </div>
                    <h3 
                      className={`text-base lg:text-lg font-bold transition-colors ${
                        selectedCoffeeType === 'blend' ? 'text-[#09543D]' : 'text-gray-800'
                      }`}
                      style={{
                        fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                        letterSpacing: '-0.5px'
                      }}
                    >
                      Blend
                    </h3>
                  </button>
                </div>
              </div>
            )}

            {/* Wholesale Brands View */}
            {selectedType === 'wholesale' && !selectedWholesaleProduct && (
              <div 
                ref={wholesaleBrandsSectionRef} 
                className={`mt-8 lg:mt-10 transition-all duration-500 ${
                  showWholesaleBrands ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'
                }`}
              >
                {/* Heading */}
                <h2 
                  className="text-xl lg:text-2xl font-bold text-gray-900 text-center mb-6 lg:mb-8"
                  style={{
                    fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                    letterSpacing: '-1px'
                  }}
                >
                  Wholesale Brands
                </h2>

                {/* Product Cards Grid */}
                <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-5 mb-6">
                  {[
                    { name: 'BRAZIL', origin: 'Brazil', type: 'Arabica', score: 93 },
                    { name: 'LUPARA ESPRESSO', origin: 'Lupara', type: 'Arabica', score: 93 },
                    { name: 'MEXICO', origin: 'Mexico', type: 'Arabica', score: 93 },
                    { name: 'ETHIOPIA', origin: 'Ethiopia', type: 'Arabica', score: 93 },
                    { name: 'COLOMBIA', origin: 'Colombia', type: 'Arabica', score: 93 },
                    { name: 'RWANDA CYESHA', origin: 'Rwanda', type: 'Arabica', score: 93 },
                    { name: 'EL SALVADOR', origin: 'El Salvador', type: 'Arabica', score: 93 },
                    { name: 'INDONESIA SUMATRA', origin: 'Indonesia', type: 'Arabica', score: 93 },
                    { name: 'GUATEMALA EL GUAPO', origin: 'Guatemala', type: 'Arabica', score: 93 },
                    { name: 'ROCKET ROAST', origin: 'Rocket', type: 'Arabica', score: 93 },
                    { name: 'PAPUA NEW GUINEA', origin: 'Papua New Guinea', type: 'Arabica', score: 93 },
                    { name: 'STARLIGHT DECAF', origin: 'Starlight', type: 'Arabica', score: 93 },
                  ]
                  .slice((wholesalePage - 1) * 8, wholesalePage * 8)
                  .map((product, index) => (
                    <div
                      key={index}
                      onClick={() => setSelectedWholesaleProduct(product.name)}
                      className={`bg-white rounded-xl border-2 p-3 hover:shadow-lg transition-all cursor-pointer ${
                        selectedWholesaleProduct === product.name
                          ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg'
                          : 'border-gray-200 hover:border-[#09543D]'
                      }`}
                    >
                      {/* Coffee Bag Image */}
                      <div className="w-full h-32 bg-gray-100 rounded-lg mb-3 flex items-center justify-center overflow-hidden">
                        <div className="w-full h-full bg-gradient-to-br from-amber-800 via-amber-900 to-amber-950 flex items-center justify-center relative">
                          {/* Coffee bag representation */}
                          <div className="w-20 h-24 bg-amber-700 rounded-lg shadow-lg relative">
                            {/* Circular label on bag */}
                            <div className="absolute top-2 left-1/2 transform -translate-x-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center">
                              <div className="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-full"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      {/* Product Name */}
                      <h3 
                        className="text-xs font-bold text-gray-900 mb-2 uppercase truncate text-center"
                        style={{
                          fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                        }}
                      >
                        {product.name}
                      </h3>

                      {/* Origin */}
                      <div className="flex items-center justify-center gap-1.5 mb-2">
                        <div className="w-3 h-3 bg-green-500 rounded-sm"></div>
                        <span className="text-[10px] text-gray-600 truncate">{product.origin}</span>
                      </div>

                      {/* Coffee Type */}
                      <p className="text-[10px] text-gray-600 text-center mb-2">{product.type}</p>

                      {/* Score */}
                      <div className="flex flex-col items-center">
                        <div className="bg-[#09543D] text-white px-2 py-1 rounded text-[10px] font-bold">
                          {product.score}
                        </div>
                        <span className="text-[9px] text-gray-500 mt-0.5">Score</span>
                      </div>
                    </div>
                  ))}
                </div>

                {/* Pagination */}
                <div className="flex flex-col items-center gap-4">
                  {/* Page indicator */}
                  <p 
                    className="text-sm text-gray-600"
                    style={{
                      fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                    }}
                  >
                    Page {wholesalePage} of {wholesaleTotalPages}
                  </p>

                  {/* Page number buttons */}
                  <div className="flex gap-2">
                    {[1, 2].map((page) => (
                      <button
                        key={page}
                        onClick={() => setWholesalePage(page)}
                        className={`w-10 h-10 rounded-lg font-bold transition-all ${
                          wholesalePage === page
                            ? 'bg-[#09543D] text-white shadow-md'
                            : 'bg-white border border-gray-200 text-gray-700 hover:border-gray-300'
                        }`}
                        style={{
                          fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                        }}
                      >
                        {page}
                      </button>
                    ))}
                  </div>

                  {/* Navigation buttons */}
                  <div className="flex gap-4">
                    <button
                      onClick={() => setWholesalePage(prev => Math.max(1, prev - 1))}
                      disabled={wholesalePage === 1}
                      className={`px-6 py-2.5 rounded-xl border font-semibold transition-all flex items-center gap-2 ${
                        wholesalePage === 1
                          ? 'bg-gray-100 border-gray-200 text-gray-400 cursor-not-allowed'
                          : 'bg-white border-gray-200 text-gray-700 hover:border-gray-300 hover:bg-gray-50'
                      }`}
                      style={{
                        fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                      }}
                    >
                      <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
                      </svg>
                      Previous
                    </button>
                    <button
                      onClick={() => setWholesalePage(prev => Math.min(wholesaleTotalPages, prev + 1))}
                      disabled={wholesalePage === wholesaleTotalPages}
                      className={`px-6 py-2.5 rounded-xl border font-semibold transition-all flex items-center gap-2 ${
                        wholesalePage === wholesaleTotalPages
                          ? 'bg-gray-100 border-gray-200 text-gray-400 cursor-not-allowed'
                          : 'bg-white border-[#09543D] text-[#09543D] hover:bg-[#09543D]/5 hover:border-[#09543D]/80'
                      }`}
                      style={{
                        fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                      }}
                    >
                      Next
                      <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
            )}

            {/* Wholesale Product Detail View */}
            {selectedType === 'wholesale' && selectedWholesaleProduct && (
              <div ref={wholesaleProductDetailRef} className="mt-8 lg:mt-10">
                {/* Back Button */}
                <button
                  onClick={() => setSelectedWholesaleProduct('')}
                  className="mb-6 flex items-center gap-2 text-gray-600 hover:text-[#09543D] transition-colors"
                  style={{
                    fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                  }}
                >
                  <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
                  </svg>
                  Back to Products
                </button>

                {/* Product Detail Layout */}
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                  {/* Left Section - Product Images */}
                  <div>
                    {/* Main Product Image */}
                    <div className="bg-gray-100 rounded-xl p-8 mb-4 flex items-center justify-center min-h-[400px]">
                      <div className="relative">
                        {/* Coffee bag representation */}
                        <div className="w-48 h-64 bg-gradient-to-br from-amber-800 via-amber-900 to-amber-950 rounded-lg shadow-2xl relative">
                          {/* Circular label on bag */}
                          <div className="absolute top-8 left-1/2 transform -translate-x-1/2 w-32 h-32 bg-white rounded-full flex items-center justify-center shadow-lg">
                            <div className="w-28 h-28 bg-gradient-to-br from-[#09543D] to-[#1E4637] rounded-full flex flex-col items-center justify-center text-white p-4 text-center">
                              <div className="text-xs font-bold mb-1">GREENSTREET</div>
                              <div className="text-lg font-bold">{selectedWholesaleProduct.split(' ')[0]}</div>
                              <div className="text-xs mt-1">{selectedWholesaleProduct.split(' ').slice(1).join(' ')}</div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    {/* Thumbnail Images */}
                    <div className="grid grid-cols-4 gap-3">
                      {[1, 2, 3, 4].map((thumb) => (
                        <div
                          key={thumb}
                          className="bg-gray-100 rounded-lg p-3 cursor-pointer hover:border-2 hover:border-[#09543D] transition-all"
                        >
                          <div className="w-full h-24 bg-gradient-to-br from-amber-800 via-amber-900 to-amber-950 rounded flex items-center justify-center">
                            <div className="w-12 h-16 bg-amber-700 rounded relative">
                              <div className="absolute top-1 left-1/2 transform -translate-x-1/2 w-6 h-6 bg-white rounded-full"></div>
                            </div>
                          </div>
                        </div>
                      ))}
                    </div>
                  </div>

                  {/* Right Section - Product Information */}
                  <div>
                    {/* Product Title */}
                    <h2
                      className="text-3xl lg:text-4xl font-bold text-[#09543D] mb-6"
                      style={{
                        fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                        letterSpacing: '-1px'
                      }}
                    >
                      {selectedWholesaleProduct}
                    </h2>

                    {/* Purchase Options */}
                    <div className="space-y-4 mb-6">
                      {/* Bag Size */}
                      <div>
                        <label
                          className="block text-sm font-semibold text-gray-700 mb-2"
                          style={{
                            fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                          }}
                        >
                          Bag Size
                        </label>
                        <select
                          value={bagSize}
                          onChange={(e) => setBagSize(e.target.value)}
                          className="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#09543D] focus:outline-none transition-colors"
                        >
                          <option>12oz Retail Bag</option>
                          <option>16oz Retail Bag</option>
                          <option>5lb Bag</option>
                        </select>
                      </div>

                      {/* Bag Price and Case Quantity Row */}
                      <div className="grid grid-cols-2 gap-4">
                        <div>
                          <label
                            className="block text-sm font-semibold text-gray-700 mb-2"
                            style={{
                              fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                            }}
                          >
                            Bag Price($)
                          </label>
                          <input
                            type="number"
                            value={bagPrice}
                            onChange={(e) => {
                              setBagPrice(e.target.value)
                              setAmount((parseFloat(e.target.value) * parseInt(caseQuantity || '1')).toString())
                            }}
                            className="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#09543D] focus:outline-none transition-colors"
                          />
                        </div>
                        <div>
                          <label
                            className="block text-sm font-semibold text-gray-700 mb-2"
                            style={{
                              fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                            }}
                          >
                            Case Quantity(8 units)
                          </label>
                          <input
                            type="number"
                            value={caseQuantity}
                            onChange={(e) => {
                              setCaseQuantity(e.target.value)
                              setAmount((parseFloat(bagPrice || '0') * parseInt(e.target.value || '1')).toString())
                            }}
                            className="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#09543D] focus:outline-none transition-colors"
                          />
                        </div>
                      </div>

                      {/* Amount */}
                      <div>
                        <label
                          className="block text-sm font-semibold text-gray-700 mb-2"
                          style={{
                            fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                          }}
                        >
                          Amount
                        </label>
                        <input
                          type="text"
                          value={`$ ${amount}`}
                          readOnly
                          className="w-full px-4 py-3 border-2 border-gray-200 rounded-lg bg-gray-50"
                        />
                      </div>

                      {/* Availability */}
                      <p className="text-sm text-gray-600">
                        1000 bags available
                      </p>

                      {/* Proceed Button */}
                      <button
                        onClick={() => {
                          // Handle proceed action
                          setShowNotification(true)
                        }}
                        className="w-full bg-[#09543D] text-white py-4 rounded-lg font-bold text-lg hover:bg-[#1E4637] transition-colors"
                        style={{
                          fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                        }}
                      >
                        Proceed
                      </button>
                    </div>

                    {/* Product Details Table */}
                    <div className="mt-8">
                      <h3
                        className="text-xl font-bold text-[#09543D] mb-4"
                        style={{
                          fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                        }}
                      >
                        Product Details
                      </h3>
                      <div className="border-2 border-gray-200 rounded-lg overflow-hidden">
                        <table className="w-full">
                          <thead className="bg-gray-50">
                            <tr>
                              <th
                                className="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b border-gray-200"
                                style={{
                                  fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                                }}
                              >
                                Info
                              </th>
                              <th
                                className="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b border-gray-200"
                                style={{
                                  fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                                }}
                              >
                                Description
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr className="border-b border-gray-200">
                              <td className="px-4 py-3 text-sm font-semibold text-gray-700">Vendor</td>
                              <td className="px-4 py-3 text-sm text-[#09543D] font-semibold">Greenstreet</td>
                            </tr>
                            <tr className="border-b border-gray-200">
                              <td className="px-4 py-3 text-sm font-semibold text-gray-700">Variety</td>
                              <td className="px-4 py-3 text-sm text-[#09543D] font-semibold">{selectedWholesaleProduct}</td>
                            </tr>
                            <tr className="border-b border-gray-200">
                              <td className="px-4 py-3 text-sm font-semibold text-gray-700">Coffee Type</td>
                              <td className="px-4 py-3 text-sm text-[#09543D] font-semibold">Arabica</td>
                            </tr>
                            <tr className="border-b border-gray-200">
                              <td className="px-4 py-3 text-sm font-semibold text-gray-700">Quality</td>
                              <td className="px-4 py-3 text-sm text-[#09543D] font-semibold">93</td>
                            </tr>
                            <tr className="border-b border-gray-200">
                              <td className="px-4 py-3 text-sm font-semibold text-gray-700">Notes</td>
                              <td className="px-4 py-3 text-sm text-[#09543D] font-semibold">Balanced, slightly sweet and acidic</td>
                            </tr>
                            <tr>
                              <td className="px-4 py-3 text-sm font-semibold text-gray-700">Process</td>
                              <td className="px-4 py-3 text-sm text-[#09543D] font-semibold">FULLY-WASHED</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            )}

            {/* Single Origin View - Coffee Cards */}
            {selectedCoffeeType === 'single-origin' && (
              <div 
                ref={singleOriginSectionRef} 
                className={`mt-8 lg:mt-10 transition-all duration-500 ${
                  showSingleOrigin ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'
                }`}
              >
                {/* Heading */}
                <h2 
                  className="text-xl lg:text-2xl font-bold text-gray-900 text-center mb-6 lg:mb-8"
                  style={{
                    fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                    letterSpacing: '-1px'
                  }}
                >
                  Single origin
                </h2>

                {/* Coffee Cards Grid */}
                <div className="grid grid-cols-2 gap-3 lg:gap-4 mb-6">
                  {/* Sample coffee cards */}
                  {[
                    { name: 'ETHIOPIA GUJI', country: 'Ethiopia', score: 88 },
                    { name: 'KENYA AB', country: 'Kenya', score: 90 },
                    { name: 'TANZANIA ZANZIBAR', country: 'Tanzania', score: 96 },
                    { name: 'PERU', country: 'Peru', score: 93 },
                    { name: 'KENYA AA', country: 'Kenya', score: 89 },
                    { name: 'ETHIOPIA', country: 'Ethiopia', score: 91 },
                    { name: 'TANZANIA PEABERRY', country: 'Tanzania', score: 93 },
                    { name: 'UGANDA BUGISHU', country: 'Uganda', score: 86 },
                    { name: 'COLOMBIA SUPREMO', country: 'Colombia', score: 92 },
                    { name: 'BRAZIL SANTOS', country: 'Brazil', score: 87 },
                    { name: 'GUATEMALA ANTIGUA', country: 'Guatemala', score: 94 },
                    { name: 'COSTA RICA TARRAZU', country: 'Costa Rica', score: 90 },
                  ]
                  .slice((currentPage - 1) * 4, currentPage * 4)
                  .map((coffee, index) => (
                    <div
                      key={index}
                      onClick={() => {
                        setSelectedCoffee(coffee.name)
                      }}
                      className={`bg-white rounded-xl border-2 p-3 hover:shadow-lg transition-all cursor-pointer ${
                        selectedCoffee === coffee.name
                          ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                          : 'border-gray-200 hover:border-[#09543D]'
                      }`}
                    >
                      {/* Coffee Bean Image */}
                      <div className="w-full h-20 bg-gray-100 rounded-lg mb-2 flex items-center justify-center">
                        <div className="w-12 h-12 bg-gradient-to-br from-green-700 to-green-900 rounded-lg"></div>
                      </div>

                      {/* Coffee Name */}
                      <h3 
                        className="text-xs font-bold text-gray-900 mb-2 uppercase truncate"
                        style={{
                          fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                        }}
                      >
                        {coffee.name}
                      </h3>

                      {/* Bottom Section */}
                      <div className="flex items-center justify-between">
                        {/* Left: Flag and Country */}
                        <div className="flex items-center gap-1.5">
                          <div className="w-3 h-3 bg-green-500 rounded-sm"></div>
                          <span className="text-[10px] text-gray-600 truncate">{coffee.country}</span>
                        </div>

                        {/* Right: Score */}
                        <div className="bg-[#D8501C] text-white px-1.5 py-0.5 rounded text-[10px] font-bold">
                          {coffee.score}
                        </div>
                      </div>
                    </div>
                  ))}
                </div>

                {/* Pagination */}
                <div className="flex flex-col items-center gap-4">
                  {/* Page indicator */}
                  <p 
                    className="text-sm text-gray-600"
                    style={{
                      fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                    }}
                  >
                    Page {currentPage} of {totalPages}
                  </p>

                  {/* Page number buttons */}
                  <div className="flex gap-2">
                    {[1, 2, 3].map((page) => (
                      <button
                        key={page}
                        onClick={() => setCurrentPage(page)}
                        className={`w-10 h-10 rounded-lg font-bold transition-all ${
                          currentPage === page
                            ? 'bg-[#D8501C] text-white shadow-md'
                            : 'bg-white border border-gray-200 text-gray-700 hover:border-gray-300'
                        }`}
                        style={{
                          fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                        }}
                      >
                        {page}
                      </button>
                    ))}
                  </div>

                  {/* Navigation buttons */}
                  <div className="flex gap-4">
                    <button
                      onClick={() => setCurrentPage(prev => Math.max(1, prev - 1))}
                      disabled={currentPage === 1}
                      className={`px-6 py-2.5 rounded-xl border font-semibold transition-all flex items-center gap-2 ${
                        currentPage === 1
                          ? 'bg-gray-100 border-gray-200 text-gray-400 cursor-not-allowed'
                          : 'bg-white border-gray-200 text-gray-700 hover:border-gray-300 hover:bg-gray-50'
                      }`}
                      style={{
                        fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                      }}
                    >
                      <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
                      </svg>
                      Previous
                    </button>
                    <button
                      onClick={() => setCurrentPage(prev => Math.min(totalPages, prev + 1))}
                      disabled={currentPage === totalPages}
                      className={`px-6 py-2.5 rounded-xl border font-semibold transition-all flex items-center gap-2 ${
                        currentPage === totalPages
                          ? 'bg-gray-100 border-gray-200 text-gray-400 cursor-not-allowed'
                          : 'bg-white border-[#09543D] text-[#09543D] hover:bg-[#09543D]/5 hover:border-[#09543D]/80'
                      }`}
                      style={{
                        fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                      }}
                    >
                      Next
                      <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
            )}

            {/* Product Selection - For Blend */}
            {selectedCoffeeType === 'blend' && (
              <div 
                ref={productSelectionSectionRef} 
                className={`mt-8 lg:mt-10 transition-all duration-500 ${
                  showProductSelection ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'
                }`}
              >
                <h2 
                  className="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 text-center mb-6 lg:mb-8"
                  style={{
                    fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                    letterSpacing: '-1.5px',
                    lineHeight: '1.1'
                  }}
                >
                  Select Product
                </h2>

                {/* Product Cards */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 max-w-4xl mx-auto">
                  {[
                    { id: 'tasty-coffee', name: 'TASTY COFFEE', origin: 'United States', type: 'Arabica', score: 98 },
                    { id: 'colombian', name: 'COLOMBIAN', origin: 'Colombian', type: 'Arabica', score: 93 },
                    { id: 'brazilian', name: 'BRAZILIAN', origin: 'Brazilian', type: 'Arabica', score: 93 },
                  ].map((product) => (
                    <button
                      key={product.id}
                      onClick={() => {
                        setSelectedProduct(product.id)
                        setTimeout(() => {
                          roastTypeSectionRef.current?.scrollIntoView({ behavior: 'smooth', block: 'start' })
                        }, 100)
                      }}
                      className={`group relative bg-white rounded-xl border-2 p-4 lg:p-5 transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${
                        selectedProduct === product.id
                          ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                          : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-lg'
                      }`}
                    >
                      {/* Selection indicator */}
                      {selectedProduct === product.id && (
                        <div className="absolute top-2 right-2 w-5 h-5 bg-[#09543D] rounded-full flex items-center justify-center z-10">
                          <svg className="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3} d="M5 13l4 4L19 7" />
                          </svg>
          </div>
                      )}

                      {/* Product Image */}
                      <div className="w-full h-40 bg-gray-100 rounded-lg mb-3 flex items-center justify-center overflow-hidden">
                        <div className="w-full h-full bg-gradient-to-br from-green-700 via-green-800 to-green-900 flex items-center justify-center">
                          <div className="grid grid-cols-4 gap-1 p-4">
                            {[...Array(16)].map((_, i) => (
                              <div key={i} className="w-3 h-3 bg-green-600 rounded-sm"></div>
                            ))}
                          </div>
                        </div>
                      </div>

                      {/* Product Name */}
                      <h3 
                        className={`text-sm lg:text-base font-bold text-gray-900 mb-2 uppercase text-center ${
                          selectedProduct === product.id ? 'text-[#09543D]' : ''
                        }`}
                        style={{
                          fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                        }}
                      >
                        {product.name}
                      </h3>

                      {/* Origin */}
                      <div className="flex items-center justify-center gap-2 mb-2">
                        <div className="w-4 h-4 bg-green-500 rounded-sm"></div>
                        <span className="text-xs text-gray-600">{product.origin}</span>
                      </div>

                      {/* Coffee Type */}
                      <p className="text-xs text-gray-600 text-center mb-3">{product.type}</p>

                      {/* Score */}
                      <div className="flex flex-col items-center">
                        <div className="bg-[#D8501C] text-white px-3 py-1.5 rounded-lg text-sm font-bold">
                          {product.score}
                        </div>
                        <span className="text-xs text-gray-500 mt-1">Score</span>
                      </div>
                    </button>
                  ))}
                </div>
              </div>
            )}

            {/* Roast Type Selection */}
            {(selectedCoffee || selectedProduct) && (
              <div 
                ref={roastTypeSectionRef} 
                className={`mt-8 lg:mt-10 transition-all duration-500 ${
                  showRoastType ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'
                }`}
              >
                <h2 
                  className="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 text-center mb-6 lg:mb-8"
                  style={{
                    fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                    letterSpacing: '-1.5px',
                    lineHeight: '1.1'
                  }}
                >
                  Select your roast type
                </h2>

                {/* Roast Type Cards */}
                <div className="grid grid-cols-2 md:grid-cols-4 gap-4 lg:gap-5 max-w-2xl mx-auto">
                  {/* Light Roast */}
                  <button
                    onClick={() => {
                      setSelectedRoastType('light')
                    }}
                    className={`group relative bg-white rounded-xl border-2 p-3 lg:p-4 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${
                      selectedRoastType === 'light'
                        ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                        : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-lg'
                    }`}
                  >
                    {/* Selection indicator */}
                    {selectedRoastType === 'light' && (
                      <div className="absolute top-2 right-2 w-4 h-4 bg-[#09543D] rounded-full flex items-center justify-center">
                        <svg className="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3} d="M5 13l4 4L19 7" />
                        </svg>
                      </div>
                    )}
                    
                    <div className="flex justify-center mb-2 lg:mb-3">
                      <img src={lightRoastIcon} alt="Light Roast" className="w-12 h-12 lg:w-16 lg:h-16 object-contain transition-transform duration-300 group-hover:scale-110" />
                    </div>
                    <h3 
                      className={`text-sm lg:text-base font-bold transition-colors ${
                        selectedRoastType === 'light' ? 'text-[#09543D]' : 'text-gray-800'
                      }`}
                      style={{
                        fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                        letterSpacing: '-0.5px'
                      }}
                    >
                      Light
                    </h3>
                  </button>

                  {/* Medium Roast */}
                  <button
                    onClick={() => {
                      setSelectedRoastType('medium')
                    }}
                    className={`group relative bg-white rounded-xl border-2 p-3 lg:p-4 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${
                      selectedRoastType === 'medium'
                        ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                        : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-lg'
                    }`}
                  >
                    {/* Selection indicator */}
                    {selectedRoastType === 'medium' && (
                      <div className="absolute top-2 right-2 w-4 h-4 bg-[#09543D] rounded-full flex items-center justify-center">
                        <svg className="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3} d="M5 13l4 4L19 7" />
                        </svg>
                      </div>
                    )}
                    
                    <div className="flex justify-center mb-2 lg:mb-3">
                      <img src={mediumRoastIcon} alt="Medium Roast" className="w-12 h-12 lg:w-16 lg:h-16 object-contain transition-transform duration-300 group-hover:scale-110" />
                    </div>
                    <h3 
                      className={`text-sm lg:text-base font-bold transition-colors ${
                        selectedRoastType === 'medium' ? 'text-[#09543D]' : 'text-gray-800'
                      }`}
                      style={{
                        fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                        letterSpacing: '-0.5px'
                      }}
                    >
                      Medium
                    </h3>
                  </button>

                  {/* Medium-Dark Roast */}
                  <button
                    onClick={() => {
                      setSelectedRoastType('medium-dark')
                    }}
                    className={`group relative bg-white rounded-xl border-2 p-3 lg:p-4 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${
                      selectedRoastType === 'medium-dark'
                        ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                        : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-lg'
                    }`}
                  >
                    {/* Selection indicator */}
                    {selectedRoastType === 'medium-dark' && (
                      <div className="absolute top-2 right-2 w-4 h-4 bg-[#09543D] rounded-full flex items-center justify-center">
                        <svg className="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3} d="M5 13l4 4L19 7" />
                        </svg>
                      </div>
                    )}
                    
                    <div className="flex justify-center mb-2 lg:mb-3">
                      <img src={mediumDarkRoastIcon} alt="Medium-Dark Roast" className="w-12 h-12 lg:w-16 lg:h-16 object-contain transition-transform duration-300 group-hover:scale-110" />
                    </div>
                    <h3 
                      className={`text-sm lg:text-base font-bold transition-colors ${
                        selectedRoastType === 'medium-dark' ? 'text-[#09543D]' : 'text-gray-800'
                      }`}
                      style={{
                        fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                        letterSpacing: '-0.5px'
                      }}
                    >
                      Medium-Dark
                    </h3>
                  </button>

                  {/* Dark Roast */}
                  <button
                    onClick={() => {
                      setSelectedRoastType('dark')
                    }}
                    className={`group relative bg-white rounded-xl border-2 p-3 lg:p-4 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${
                      selectedRoastType === 'dark'
                        ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                        : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-lg'
                    }`}
                  >
                    {/* Selection indicator */}
                    {selectedRoastType === 'dark' && (
                      <div className="absolute top-2 right-2 w-4 h-4 bg-[#09543D] rounded-full flex items-center justify-center">
                        <svg className="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3} d="M5 13l4 4L19 7" />
                        </svg>
                      </div>
                    )}
                    
                    <div className="flex justify-center mb-2 lg:mb-3">
                      <img src={darkRoastIcon} alt="Dark Roast" className="w-12 h-12 lg:w-16 lg:h-16 object-contain transition-transform duration-300 group-hover:scale-110" />
                    </div>
                    <h3 
                      className={`text-sm lg:text-base font-bold transition-colors ${
                        selectedRoastType === 'dark' ? 'text-[#09543D]' : 'text-gray-800'
                      }`}
                      style={{
                        fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                        letterSpacing: '-0.5px'
                      }}
                    >
                      Dark
                    </h3>
                  </button>
                </div>
              </div>
            )}

            {/* Grind Type Selection */}
            {selectedRoastType && (
              <div 
                ref={grindTypeSectionRef} 
                className={`mt-8 lg:mt-10 transition-all duration-500 ${
                  showGrindType ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'
                }`}
              >
                <h2 
                  className="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 text-center mb-6 lg:mb-8"
                  style={{
                    fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                    letterSpacing: '-1.5px',
                    lineHeight: '1.1'
                  }}
                >
                  Select your grind type
                </h2>

                {/* Grind Type Cards */}
                <div className="grid grid-cols-2 md:grid-cols-5 gap-4 lg:gap-5 max-w-3xl mx-auto">
                  {/* Whole Bean */}
                  <button
                    onClick={() => {
                      setSelectedGrindType('whole-bean')
                    }}
                    className={`group relative bg-white rounded-xl border-2 p-3 lg:p-4 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${
                      selectedGrindType === 'whole-bean'
                        ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                        : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-lg'
                    }`}
                  >
                    {/* Selection indicator */}
                    {selectedGrindType === 'whole-bean' && (
                      <div className="absolute top-2 right-2 w-4 h-4 bg-[#09543D] rounded-full flex items-center justify-center">
                        <svg className="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3} d="M5 13l4 4L19 7" />
                        </svg>
                      </div>
                    )}
                    
                    <div className="flex justify-center mb-2 lg:mb-3">
                      <img src={lightRoastIcon} alt="Whole Bean" className="w-12 h-12 lg:w-16 lg:h-16 object-contain transition-transform duration-300 group-hover:scale-110" />
                    </div>
                    <h3 
                      className={`text-sm lg:text-base font-bold transition-colors ${
                        selectedGrindType === 'whole-bean' ? 'text-[#09543D]' : 'text-gray-800'
                      }`}
                      style={{
                        fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                        letterSpacing: '-0.5px'
                      }}
                    >
                      Whole bean
                    </h3>
                  </button>

                  {/* Coarse */}
                  <button
                    onClick={() => {
                      setSelectedGrindType('coarse')
                    }}
                    className={`group relative bg-white rounded-xl border-2 p-3 lg:p-4 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${
                      selectedGrindType === 'coarse'
                        ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                        : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-lg'
                    }`}
                  >
                    {/* Selection indicator */}
                    {selectedGrindType === 'coarse' && (
                      <div className="absolute top-2 right-2 w-4 h-4 bg-[#09543D] rounded-full flex items-center justify-center">
                        <svg className="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3} d="M5 13l4 4L19 7" />
                        </svg>
                      </div>
                    )}
                    
                    <div className="flex justify-center mb-2 lg:mb-3">
                      <img src={lightRoastIcon} alt="Coarse" className="w-12 h-12 lg:w-16 lg:h-16 object-contain transition-transform duration-300 group-hover:scale-110" />
                    </div>
                    <h3 
                      className={`text-sm lg:text-base font-bold transition-colors ${
                        selectedGrindType === 'coarse' ? 'text-[#09543D]' : 'text-gray-800'
                      }`}
                      style={{
                        fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                        letterSpacing: '-0.5px'
                      }}
                    >
                      Coarse
                    </h3>
                  </button>

                  {/* Medium */}
                  <button
                    onClick={() => {
                      setSelectedGrindType('medium')
                    }}
                    className={`group relative bg-white rounded-xl border-2 p-3 lg:p-4 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${
                      selectedGrindType === 'medium'
                        ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                        : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-lg'
                    }`}
                  >
                    {/* Selection indicator */}
                    {selectedGrindType === 'medium' && (
                      <div className="absolute top-2 right-2 w-4 h-4 bg-[#09543D] rounded-full flex items-center justify-center">
                        <svg className="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3} d="M5 13l4 4L19 7" />
                        </svg>
                      </div>
                    )}
                    
                    <div className="flex justify-center mb-2 lg:mb-3">
                      <img src={mediumRoastIcon} alt="Medium" className="w-12 h-12 lg:w-16 lg:h-16 object-contain transition-transform duration-300 group-hover:scale-110" />
                    </div>
                    <h3 
                      className={`text-sm lg:text-base font-bold transition-colors ${
                        selectedGrindType === 'medium' ? 'text-[#09543D]' : 'text-gray-800'
                      }`}
                      style={{
                        fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                        letterSpacing: '-0.5px'
                      }}
                    >
                      Medium
                    </h3>
                  </button>

                  {/* Fine */}
                  <button
                    onClick={() => {
                      setSelectedGrindType('fine')
                    }}
                    className={`group relative bg-white rounded-xl border-2 p-3 lg:p-4 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${
                      selectedGrindType === 'fine'
                        ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                        : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-lg'
                    }`}
                  >
                    {/* Selection indicator */}
                    {selectedGrindType === 'fine' && (
                      <div className="absolute top-2 right-2 w-4 h-4 bg-[#09543D] rounded-full flex items-center justify-center">
                        <svg className="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3} d="M5 13l4 4L19 7" />
                        </svg>
                      </div>
                    )}
                    
                    <div className="flex justify-center mb-2 lg:mb-3">
                      <img src={mediumDarkRoastIcon} alt="Fine" className="w-12 h-12 lg:w-16 lg:h-16 object-contain transition-transform duration-300 group-hover:scale-110" />
                    </div>
                    <h3 
                      className={`text-sm lg:text-base font-bold transition-colors ${
                        selectedGrindType === 'fine' ? 'text-[#09543D]' : 'text-gray-800'
                      }`}
                      style={{
                        fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                        letterSpacing: '-0.5px'
                      }}
                    >
                      Fine
                    </h3>
                  </button>

                  {/* Extra Fine */}
                  <button
                    onClick={() => {
                      setSelectedGrindType('extra-fine')
                    }}
                    className={`group relative bg-white rounded-xl border-2 p-3 lg:p-4 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${
                      selectedGrindType === 'extra-fine'
                        ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                        : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-lg'
                    }`}
                  >
                    {/* Selection indicator */}
                    {selectedGrindType === 'extra-fine' && (
                      <div className="absolute top-2 right-2 w-4 h-4 bg-[#09543D] rounded-full flex items-center justify-center">
                        <svg className="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3} d="M5 13l4 4L19 7" />
                        </svg>
                      </div>
                    )}
                    
                    <div className="flex justify-center mb-2 lg:mb-3">
                      <img src={darkRoastIcon} alt="Extra Fine" className="w-12 h-12 lg:w-16 lg:h-16 object-contain transition-transform duration-300 group-hover:scale-110" />
                    </div>
                    <h3 
                      className={`text-sm lg:text-base font-bold transition-colors ${
                        selectedGrindType === 'extra-fine' ? 'text-[#09543D]' : 'text-gray-800'
                      }`}
                      style={{
                        fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                        letterSpacing: '-0.5px'
                      }}
                    >
                      Extra fine
                    </h3>
                  </button>
                </div>
              </div>
            )}

            {/* Package Size Selection */}
            {selectedGrindType && (
              <div 
                ref={packageSizeSectionRef} 
                className={`mt-8 lg:mt-10 transition-all duration-500 w-full ${
                  showPackageSize ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'
                }`}
              >
                <h2 
                  className="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 text-center mb-8 lg:mb-10"
                  style={{
                    fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                    letterSpacing: '-1.5px',
                    lineHeight: '1.1'
                  }}
                >
                  Select your package size and customize it
                </h2>

                <div className="w-full max-w-6xl mx-auto space-y-6 lg:space-y-8">
                  {/* Top Row - Package Sizes (Horizontal) */}
                  <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3 lg:gap-4">
                    {packageSizes.map((pkg) => (
                      <button
                        key={pkg.id}
                        onClick={() => setSelectedPackageSize(pkg.id)}
                        className={`relative text-center p-4 lg:p-5 rounded-xl border-2 transition-all duration-300 transform hover:scale-[1.02] ${
                          selectedPackageSize === pkg.id
                            ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                            : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-md bg-white'
                        }`}
                      >
                        <h3 
                          className={`font-bold text-sm lg:text-base transition-colors ${
                            selectedPackageSize === pkg.id ? 'text-[#09543D]' : 'text-gray-800'
                          }`}
                          style={{
                            fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                            letterSpacing: '-0.5px'
                          }}
                        >
                          {pkg.name}
                        </h3>
                        {selectedPackageSize === pkg.id && (
                          <div className="absolute top-2 right-2 w-5 h-5 bg-[#09543D] rounded-full flex items-center justify-center">
                            <svg className="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3} d="M5 13l4 4L19 7" />
                            </svg>
                          </div>
                        )}
                      </button>
                    ))}
                  </div>

                  {/* Logo Upload Dropzone - Horizontal */}
                  {selectedPackageSize && selectedPackage && (
                    <label 
                      ref={dropzoneSectionRef}
                      className="block w-full p-6 lg:p-8 rounded-2xl border-2 border-dashed border-gray-300 hover:border-[#09543D] cursor-pointer transition-all bg-white hover:bg-gray-50 group relative"
                    >
                      <div className="flex flex-row items-center justify-center gap-4">
                        <div className="w-12 h-12 rounded-full bg-[#09543D]/10 flex items-center justify-center group-hover:bg-[#09543D]/20 transition-colors flex-shrink-0">
                          <svg className="w-6 h-6 text-[#09543D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                          </svg>
                        </div>
                        <div className="text-center flex-1">
                          <span className="text-base font-semibold text-gray-700 group-hover:text-[#09543D] transition-colors block mb-1">Upload your logo</span>
                          <span className="text-sm text-gray-500">Click to browse or drag and drop</span>
                        </div>
                        {logoPreview && (
                          <div className="flex items-center gap-3">
                            <img src={logoPreview} alt="Your logo" className="max-h-16 object-contain rounded-lg" />
                            <div className="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                              <svg className="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3} d="M5 13l4 4L19 7" />
                              </svg>
                            </div>
                          </div>
                        )}
                      </div>
                      <input
                        type="file"
                        accept="image/*"
                        onChange={handleLogoUpload}
                        className="hidden"
                      />
                    </label>
                  )}

                  {/* Bag Image Card - Full Width */}
                  {selectedPackageSize && selectedPackage && (
                    <div className="bg-white rounded-2xl border-2 border-gray-200 p-6 lg:p-8 shadow-lg">
                      {/* Package Title */}
                      <div className="mb-6 pb-6 border-b border-gray-200">
                        <h3 
                          className="text-2xl lg:text-3xl font-bold text-gray-900 mb-2"
                          style={{
                            fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                            letterSpacing: '-1px'
                          }}
                        >
                          {selectedPackage.name}
                        </h3>
                        <p className="text-gray-500 text-sm">Customize your packaging</p>
                      </div>

                      {/* Bag Image */}
                      <div className="flex justify-center">
                        <div className="relative w-full max-w-xs">
                          {/* Bag representation */}
                          <div className="bg-gradient-to-b from-gray-800 via-gray-700 to-gray-900 rounded-2xl p-6 lg:p-8 shadow-2xl relative">
                            {/* Bag shape - Stand-up pouch */}
                            <div className="bg-gray-800 rounded-xl h-64 flex flex-col items-center justify-center relative overflow-hidden">
                              {/* Top seal */}
                              <div className="absolute top-0 left-0 right-0 h-2 bg-gray-900"></div>
                              
                              {/* Valve */}
                              <div className="absolute top-3 right-3 w-4 h-4 bg-gray-600 rounded-full border-2 border-gray-500"></div>
                              
                              {/* Design area with logo or placeholder */}
                              <div className="w-4/5 h-32 border-2 border-dashed border-white/40 rounded-lg flex items-center justify-center bg-gray-700/60 backdrop-blur-sm mt-12 mb-4">
                                {logoPreview ? (
                                  <img src={logoPreview} alt="Your logo" className="max-w-full max-h-full object-contain p-2" />
                                ) : (
                                  <span className="text-white/70 text-xs text-center px-3 font-medium">YOUR DESIGN HERE</span>
                                )}
                              </div>
                              
                              {/* Bottom zipper */}
                              <div className="absolute bottom-0 left-0 right-0 h-3 bg-gradient-to-b from-gray-600 to-gray-700 flex items-center justify-center">
                                <div className="w-12 h-1 bg-gray-500 rounded-full"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  )}

                  {/* Details and Quantity Card - Full Width */}
                  {selectedPackageSize && selectedPackage && (
                    <div className="bg-white rounded-2xl border-2 border-gray-200 p-6 lg:p-8 shadow-lg">
                          {/* Bag Details */}
                          <div className="mb-6">
                            <h4 
                              className="text-lg font-bold text-gray-800 mb-4"
                              style={{
                                fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                              }}
                            >
                              Bag details
                            </h4>
                            <div className="space-y-3 text-gray-700">
                              <div className="flex items-start gap-2">
                                <svg className="w-5 h-5 text-[#09543D] mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                                </svg>
                                <p><span className="font-semibold">Size:</span> {selectedPackage.details.size}</p>
                              </div>
                              <div className="flex items-start gap-2">
                                <svg className="w-5 h-5 text-[#09543D] mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                </svg>
                                <p><span className="font-semibold">Color:</span> {selectedPackage.details.color}</p>
                              </div>
                              <div className="flex items-start gap-2">
                                <svg className="w-5 h-5 text-[#09543D] mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <p>Roasted in the USA</p>
                              </div>
                              <div className="flex items-start gap-2">
                                <svg className="w-5 h-5 text-[#09543D] mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p><span className="font-semibold">Label size:</span> {selectedPackage.details.labelSize}</p>
                              </div>
                            </div>
                          </div>

                          {/* Quantity Input */}
                          <div>
                            <label 
                              className="block text-sm font-bold text-gray-700 mb-3"
                              style={{
                                fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                              }}
                            >
                              <span className="flex items-center gap-2">
                                <svg className="w-5 h-5 text-[#09543D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                QUANTITY (# OF BAGS) *
                              </span>
                            </label>
                            <input
                              type="number"
                              min="1"
                              value={quantity}
                              onChange={(e) => setQuantity(e.target.value)}
                              placeholder="Enter quantity"
                              className="w-full px-4 py-3.5 border-2 border-[#D8501C]/50 rounded-xl focus:outline-none focus:border-[#D8501C] focus:ring-2 focus:ring-[#D8501C]/20 transition-all text-lg font-semibold"
                              style={{
                                fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                              }}
                            />
                          </div>

                          {/* Confirm and Proceed Button */}
                          <div className="mt-6 pt-6 border-t border-gray-200">
                            <button
                              onClick={() => {
                                setIsLoading(true)
                                setTimeout(() => {
                                  setIsLoading(false)
                                  setShowNotification(true)
                                }, 1500)
                              }}
                              disabled={isLoading}
                              className="w-full px-6 py-4 bg-[#09543D] text-white rounded-xl font-bold text-lg hover:bg-[#0d6b4f] transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-[1.02] disabled:opacity-70 disabled:cursor-not-allowed disabled:transform-none flex items-center justify-center gap-3"
                              style={{
                                fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                              }}
                            >
                              {isLoading ? (
                                <>
                                  <svg className="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle>
                                    <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                  </svg>
                                  <span>Processing...</span>
                                </>
                              ) : (
                                'Confirm and Proceed'
                              )}
                            </button>
                          </div>
                        </div>
                  )}
                </div>
              </div>
            )}

          </div>

          {/* Notification Modal - Positioned in Right Section */}
          {showNotification && (
            <div 
              className="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
              onClick={() => setShowNotification(false)}
            >
              <div 
                className="bg-white rounded-2xl p-8 lg:p-10 max-w-md w-full shadow-2xl transform transition-all"
                onClick={(e) => e.stopPropagation()}
              >
                <div className="text-center">
                  {/* Success Icon */}
                  <div className="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-6">
                    <svg className="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                    </svg>
                  </div>
                  
                  {/* Title */}
                  <h3 
                    className="text-3xl lg:text-4xl font-bold text-gray-900 mb-4"
                    style={{
                      fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                      letterSpacing: '-1px'
                    }}
                  >
                    All Done
                  </h3>
                  
                  {/* Message */}
                  <p className="text-gray-600 text-lg mb-6">
                    We will send you an email to proceed to make payment
                  </p>
                  
                  {/* Close Button */}
                  <button
                    onClick={() => setShowNotification(false)}
                    className="px-8 py-3 bg-[#09543D] text-white rounded-xl font-bold hover:bg-[#0d6b4f] transition-all duration-200 shadow-lg hover:shadow-xl"
                    style={{
                      fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                    }}
                  >
                    Close
                  </button>
                </div>
              </div>
            </div>
          )}

          {/* Logout Confirmation Modal */}
          {showLogoutConfirm && (
            <div 
              className="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
              onClick={() => setShowLogoutConfirm(false)}
            >
              <div 
                className="bg-white rounded-2xl p-8 lg:p-10 max-w-md w-full shadow-2xl transform transition-all"
                onClick={(e) => e.stopPropagation()}
              >
                <div className="text-center">
                  {/* Warning Icon */}
                  <div className="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-6">
                    <svg className="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                  </div>
                  
                  {/* Title */}
                  <h3 
                    className="text-3xl lg:text-4xl font-bold text-gray-900 mb-4"
                    style={{
                      fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                      letterSpacing: '-1px'
                    }}
                  >
                    Confirm Logout
                  </h3>
                  
                  {/* Message */}
                  <p className="text-gray-600 text-lg mb-6">
                    Are you sure you want to logout? You will need to sign in again to access your account.
                  </p>
                  
                  {/* Buttons */}
                  <div className="flex gap-4 justify-center">
                    <button
                      onClick={() => setShowLogoutConfirm(false)}
                      className="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-300 transition-all duration-200"
                      style={{
                        fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                      }}
                    >
                      Cancel
                    </button>
                    <button
                      onClick={() => {
                        setShowLogoutConfirm(false)
                        navigate('/signin')
                      }}
                      className="px-6 py-3 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 transition-all duration-200 shadow-lg hover:shadow-xl"
                      style={{
                        fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                      }}
                    >
                      Logout
                    </button>
                  </div>
                </div>
              </div>
            </div>
          )}
        </div>
      </div>

      {/* Chat Button */}
      <ChatButton />
    </div>
  )
}

export default BuyerWizard

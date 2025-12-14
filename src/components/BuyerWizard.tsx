import { useState, useRef, useEffect, useCallback } from 'react'
import { Link, useNavigate } from 'react-router-dom'
import vianextaLogo from '../../assets/vianexta-logo.svg'
import roastedIcon from '../../assets/roasted.svg'
import wholesaleBrandsIcon from '../../assets/wholesale-brands.svg'
import singleOriginIcon from '../../assets/single-origin.svg'
import blendIcon from '../../assets/blend.svg'
import lightRoastIcon from '../../assets/light.svg'
import mediumRoastIcon from '../../assets/medium.svg'
import mediumDarkRoastIcon from '../../assets/medium-dark.svg'
import darkRoastIcon from '../../assets/dark.svg'
import ClareSidePanel from './ClareSidePanel'
import { stockPostingsApi, cartApi, wholesaleApi, buyerApi } from '../utils/api'

interface UserProfile {
  userFullName?: string
  name?: string
  firstName?: string
  businessName?: string
  email?: string
  phoneNumber?: string
  jobTitle?: string
  elevation?: string
  foundedYear?: string
  imageUrl?: string
}

interface StockPosting {
  id: number
  description?: string
  name?: string
  coffeeType?: string
  productType?: string
  bagPrice?: number | string
  bagWeight?: number | string
  spotPrice?: number | string
  spot_price?: number | string
  price?: number | string
  scaScoreComponents?: Record<string, number>
  supplierInfo?: {
    billingCountry?: string
    firstName?: string
  }
  imageUrl?: string
  imgUrl?: string
  variety?: string
  quality?: string
  aroma?: string
  process?: string
  quantityLeft?: number
  quantityPosted?: number
  productName?: string
  originCountry?: string
}

interface CartItem {
  stockPosting?: StockPosting | Record<string, unknown>
  numBags?: number
  quantity?: number
  bagSize?: string
  grindType?: string
  roastType?: string
  bagImage?: string
  isRoast?: boolean
}

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
  const [logoPreview, setLogoPreview] = useState<string>('')
  const [showNotification, setShowNotification] = useState(false)
  const [notificationType, setNotificationType] = useState<'cart' | 'payment'>('cart')
  const [fracPackSize, setFracPackSize] = useState<string>('3oz') // For frac pack size selection
  const [productAmount, setProductAmount] = useState<string>('0.00') // For regular product amount calculation
  const [bagPreviewImages, setBagPreviewImages] = useState<string[]>([]) // For bag preview thumbnails
  const [selectedPreviewImage, setSelectedPreviewImage] = useState<string>('') // Currently selected preview image
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

  // New UI Features State
  const [showBlendDetails, setShowBlendDetails] = useState(false)
  const [showDoneStep, setShowDoneStep] = useState(false)
  const [activeInfoModal, setActiveInfoModal] = useState<{ title: string, content: string, image: string } | null>(null)

  // Clare Panel State
  const [isChatMinimized, setIsChatMinimized] = useState(false)


  // API Data States
  const [singleOriginProducts, setSingleOriginProducts] = useState<StockPosting[]>([])
  const [blendProducts, setBlendProducts] = useState<StockPosting[]>([])
  const [wholesaleProducts, setWholesaleProducts] = useState<StockPosting[]>([])
  const [originalWholesaleProducts, setOriginalWholesaleProducts] = useState<StockPosting[]>([]) // Store original for search reset
  const [selectedProductData, setSelectedProductData] = useState<StockPosting | null>(null)
  const [loadingProducts, setLoadingProducts] = useState(false)
  const [searchQuery, setSearchQuery] = useState('')
  const [cartItemsCount, setCartItemsCount] = useState(0)
  const [currentBagImage, setCurrentBagImage] = useState<string>('')
  const [isAuthenticated, setIsAuthenticated] = useState(false)
  const [userProfile, setUserProfile] = useState<UserProfile | null>(null)

  const [showCart, setShowCart] = useState(false)
  const [loadingCartItems, setLoadingCartItems] = useState(false)
  const [cartItemsList, setCartItemsList] = useState<CartItem[]>([])
  const [showComingSoonModal, setShowComingSoonModal] = useState(false)
  const [comingSoonFeature, setComingSoonFeature] = useState<string>('')

  // Bag image mapping based on package size - using local images from public folder
  const bagImageMap: { [key: string]: string } = {
    '5lb': '/images/buyer/5lb_1.jpg',
    '12oz': '/images/buyer/12oz_1.png',
    '10oz': '/images/buyer/10oz_1.png',
    'frac': '/images/buyer/frac_pack.png',
    'kcup': '/images/buyer/kcup.jpg',
  }

  // const totalPages = 3 // Reserved for future pagination
  // const wholesaleTotalPages = 2 // Reserved for future pagination
  const coffeeTypeSectionRef = useRef<HTMLDivElement>(null)
  const singleOriginSectionRef = useRef<HTMLDivElement>(null)
  const productSelectionSectionRef = useRef<HTMLDivElement>(null)
  const wholesaleBrandsSectionRef = useRef<HTMLDivElement>(null)
  const roastTypeSectionRef = useRef<HTMLDivElement>(null)
  const grindTypeSectionRef = useRef<HTMLDivElement>(null)
  const packageSizeSectionRef = useRef<HTMLDivElement>(null)
  const dropzoneSectionRef = useRef<HTMLLabelElement>(null)
  const wholesaleProductDetailRef = useRef<HTMLDivElement>(null)
  const logoInputRef = useRef<HTMLInputElement>(null)

  // Fetch Cart Items for Modal
  const fetchCartItems = async () => {
    try {
      setLoadingCartItems(true)
      const response = await cartApi.getCartItems()
      if (response?.statusCode === 200 && Array.isArray(response.data)) {
        setCartItemsList(response.data)
      }
    } catch (error) {
      console.error('Error fetching cart items:', error)
    } finally {
      setLoadingCartItems(false)
    }
  }

  // Fetch products and filter options on mount
  useEffect(() => {
    const fetchInitialData = async () => {
      setLoadingProducts(true)

      // 1. Handle Auth & Profile
      try {
        const token = localStorage.getItem('authToken')
        const userStr = localStorage.getItem('user')
        const isAuth = !!token || !!userStr
        setIsAuthenticated(isAuth)

        if (isAuth) {
          // Try to get user profile from localStorage first for immediate display
          if (userStr) {
            try {
              setUserProfile(JSON.parse(userStr))
            } catch (e) {
              console.error('Error parsing user profile from local storage', e)
            }
          }

          // Fetch fresh profile data from API
          try {
            const profileResponse = await buyerApi.getBuyerProfile()
            if (profileResponse?.statusCode === 200 && profileResponse.data) {
              setUserProfile(profileResponse.data)
              localStorage.setItem('user', JSON.stringify(profileResponse.data))
            }
          } catch (apiError) {
            console.error('Error fetching fresh user profile:', apiError)
          }
        }
      } catch (authError) {
        console.error('Error in auth check:', authError)
      }

      // 2. Fetch Filter Options (Independent) - stored for potential future use
      try {
        await stockPostingsApi.getFilterOptions()
        // Filter options fetched but not currently used in UI
      } catch (filterError) {
        console.error('Error fetching filter options:', filterError)
      }

      // 3. Fetch Cart Items (Independent)
      try {
        const cartResponse = await cartApi.getCartItems()
        if (cartResponse?.statusCode === 200) {
          const items = Array.isArray(cartResponse.data) ? cartResponse.data : []
          setCartItemsCount(items.length)
          setCartItemsList(items) // Also populate list
        }
      } catch (cartError) {
        console.error('Error fetching cart items:', cartError)
      }

      setLoadingProducts(false)
    }

    fetchInitialData()
  }, [])

  // Check for success message from payment redirect
  useEffect(() => {
    const params = new URLSearchParams(window.location.search)
    if (params.get('payment_success') === 'true' || params.get('success') === 'true') {
      setNotificationType('payment')
      setShowNotification(true)
      // Clear query params without refresh
      window.history.replaceState({}, '', window.location.pathname)
      // Refresh cart count
      cartApi.getCartItems().then(response => {
        if (response?.statusCode === 200 && Array.isArray(response.data)) {
          setCartItemsCount(response.data.length)
        }
      })
    }
  }, [])


  // Fetch single origin products when selected
  useEffect(() => {
    if (selectedCoffeeType === 'single-origin') {
      const fetchSingleOrigin = async () => {
        try {
          setLoadingProducts(true)
          const response = await stockPostingsApi.getStockPostings({
            productType: 'roasted_single_origin'
          })
          if (response?.statusCode === 200) {
            setSingleOriginProducts(response.data || [])
          }
        } catch (error) {
          console.error('Error fetching single origin products:', error)
        } finally {
          setLoadingProducts(false)
        }
      }
      fetchSingleOrigin()
    }
  }, [selectedCoffeeType])

  // Fetch blend products when selected
  useEffect(() => {
    if (selectedCoffeeType === 'blend') {
      const fetchBlends = async () => {
        try {
          setLoadingProducts(true)
          const response = await stockPostingsApi.getStockPostings({
            productType: 'roasted_blend'
          })
          if (response?.statusCode === 200) {
            setBlendProducts(response.data || [])
          }
        } catch (error) {
          console.error('Error fetching blend products:', error)
        } finally {
          setLoadingProducts(false)
        }
      }
      fetchBlends()
    }
  }, [selectedCoffeeType])

  // Fetch wholesale products and brands when selected
  useEffect(() => {
    if (selectedType === 'wholesale') {
      const fetchWholesale = async () => {
        try {
          setLoadingProducts(true)
          setSearchQuery('') // Reset search when switching to wholesale
          setWholesalePage(1) // Reset pagination
          const [productsResponse, brandsResponse] = await Promise.all([
            stockPostingsApi.getStockPostings({ productType: 'whole_sale_brand' }),
            wholesaleApi.getWholesaleBrands()
          ])

          if (productsResponse?.statusCode === 200) {
            const products = productsResponse.data || []
            setWholesaleProducts(products)
            setOriginalWholesaleProducts(products) // Store original for search reset
          }
          if (brandsResponse?.statusCode === 200) {
            // Wholesale brands fetched but not currently used in UI
            // brandsResponse.data || []
          }
        } catch (error) {
          console.error('Error fetching wholesale products:', error)
        } finally {
          setLoadingProducts(false)
        }
      }
      fetchWholesale()
    }
  }, [selectedType])

  useEffect(() => {
    if (selectedType === 'roasted') {
      // Show roasted options
      setTimeout(() => setShowCoffeeType(true), 50)

      // Hide wholesale options
      setShowWholesaleBrands(false)
      setSelectedWholesaleProduct('')
    } else if (selectedType === 'wholesale') {
      // Show wholesale options
      setTimeout(() => setShowWholesaleBrands(true), 50)

      // Hide roasted options
      setShowCoffeeType(false)
      setShowSingleOrigin(false)
      setShowProductSelection(false)
      setShowRoastType(false)
      setShowGrindType(false)
      setShowPackageSize(false)

      // Reset roasted selections
      setSelectedCoffeeType('')

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
      // Reset all if nothing selected
      setShowCoffeeType(false)
      setShowSingleOrigin(false)
      setShowProductSelection(false)
      setShowWholesaleBrands(false)
      setShowRoastType(false)
      setShowGrindType(false)
      setShowPackageSize(false)
    }
  }, [selectedType])

  useEffect(() => {
    if (selectedCoffeeType === 'single-origin') {
      setTimeout(() => setShowSingleOrigin(true), 50)
      setSearchQuery('') // Reset search when switching
      setCurrentPage(1) // Reset pagination
    } else if (selectedCoffeeType === 'blend') {
      setTimeout(() => setShowProductSelection(true), 50)
      setSearchQuery('') // Reset search when switching
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
      const reader = new FileReader()
      reader.onloadend = () => {
        setLogoPreview(reader.result as string)
      }
      reader.readAsDataURL(file)
    }
  }

  // Handle logo deletion
  const handleLogoDelete = () => {
    setLogoPreview('')
    // Reset the file input so the same file can be uploaded again
    if (logoInputRef.current) {
      logoInputRef.current.value = ''
    }
  }


  // Update bag image when package size changes
  useEffect(() => {
    if (selectedPackageSize) {
      const bagImage = bagImageMap[selectedPackageSize] || bagImageMap['12oz']
      console.log('Setting bag image for package size:', selectedPackageSize, 'Image URL:', bagImage)
      setCurrentBagImage(bagImage)
      setSelectedPreviewImage(bagImage)

      // Set preview images based on package size (using same image for now, can be expanded)
      const previewImages = [bagImage, bagImage, bagImage, bagImage]
      setBagPreviewImages(previewImages)
    } else {
      // Set default image when no package is selected
      setCurrentBagImage('')
      setSelectedPreviewImage('')
      setBagPreviewImages([])
    }
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [selectedPackageSize])

  // Package weight mapping (in pounds) for calculation
  // This is used to calculate the total price: quantity * (spot_price * bag_weight)
  const packageWeightMap: { [key: string]: number } = {
    '5lb': 5,
    '12oz': 0.75, // 12oz = 0.75lb
    '10oz': 0.625, // 10oz = 0.625lb
    'frac': fracPackSize === '3oz' ? 0.1875 : 0.25, // 3oz = 0.1875lb, 4oz = 0.25lb
    'kcup': 0.75, // Approximate weight for K-cup box
  }

  // Calculate product amount when quantity or price changes (for regular products)
  useEffect(() => {
    if (selectedType !== 'wholesale' && quantity && selectedProductData) {
      const qty = parseFloat(quantity) || 0

      // Try multiple possible field names for spot price (price per pound)
      // The API might return it as spotPrice, spot_price, price, or we need to calculate from bagPrice
      let spotPrice = parseFloat(
        String(selectedProductData.spotPrice ||
        selectedProductData.spot_price ||
        selectedProductData.price ||
        '0')
      ) || 0

      // If spotPrice is 0, try to derive from bagPrice and bagWeight
      // bagPrice is total price for a bag, bagWeight is in pounds
      if (spotPrice === 0 && selectedProductData.bagPrice && selectedProductData.bagWeight) {
        const bagPrice = parseFloat(String(selectedProductData.bagPrice)) || 0
        const bagWeight = parseFloat(String(selectedProductData.bagWeight)) || 1
        spotPrice = bagWeight > 0 ? bagPrice / bagWeight : 0
      }

      // Use selected package size or default to '12oz' (most common)
      const packageSize = selectedPackageSize || '12oz'
      const bagWeight = packageWeightMap[packageSize] || 0.75 // Default to 12oz weight

      // For regular products: quantity * (spot_price * bag_weight)
      // This matches the web version calculation: quantity * (spot_price * package_size)
      if (spotPrice > 0 && bagWeight > 0 && qty > 0) {
        const total = qty * (spotPrice * bagWeight)
        setProductAmount(total.toFixed(2))
      } else {
        // Debug logging
        if (qty > 0) {
          console.log('Amount calculation debug:', {
            qty,
            spotPrice,
            bagWeight,
            packageSize,
            productData: {
              spotPrice: selectedProductData.spotPrice,
              spot_price: selectedProductData.spot_price,
              price: selectedProductData.price,
              bagPrice: selectedProductData.bagPrice,
              bagWeight: selectedProductData.bagWeight
            }
          })
        }
        setProductAmount('0.00')
      }
    } else {
      setProductAmount('0.00')
    }
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [quantity, selectedProductData, selectedType, selectedPackageSize, fracPackSize])


  // Handle product selection
  const handleProductSelect = async (productId: number | string, productType: 'single-origin' | 'blend' | 'wholesale') => {
    try {
      const id = typeof productId === 'string' ? parseInt(productId) : productId
      const response = await stockPostingsApi.getStockPostingById(id)
      if (response?.statusCode === 200) {
        setSelectedProductData(response.data)
        if (productType === 'single-origin') {
          setSelectedCoffee(String(productId))
        } else if (productType === 'blend') {
          setSelectedProduct(String(productId))
        } else {
          // For wholesale products, set initial values
          setSelectedWholesaleProduct(String(productId))
          if (response.data?.bagPrice) {
            setBagPrice(response.data.bagPrice.toString())
          }
          setCaseQuantity('1')
          // Calculate initial amount
          const price = parseFloat(response.data?.bagPrice || '0')
          setAmount(price.toString())
        }
      }
    } catch (error) {
      console.error('Error fetching product details:', error)
    }
  }

  // Handle add to cart
  const handleAddToCart = async () => {
    if (!selectedProductData) {
      alert('Please select a product')
      return
    }

    // Require login before adding to cart
    if (!isAuthenticated) {
      if (confirm('You must be signed in to add items to your cart.')) {
        navigate('/signin')
      }
      return
    }

    // For wholesale, use caseQuantity; for others, use quantity
    const qty = selectedType === 'wholesale' ? caseQuantity : quantity
    if (!qty) {
      alert('Please enter quantity')
      return
    }

    try {
      setIsLoading(true)
      // Determine bag size - use frac pack size if frac pack is selected
      let finalBagSize = selectedType === 'wholesale' ? bagSize : (selectedPackageSize || bagSize)
      if (selectedPackageSize === 'frac') {
        finalBagSize = `frac_pack_${fracPackSize}`
      }

      const cartItem = {
        stockPostingId: selectedProductData.id,
        numBags: parseInt(qty), // Use numBags instead of quantity to match API
        bagSize: finalBagSize,
        grindType: selectedGrindType || undefined,
        roastType: selectedRoastType || undefined,
        bagImage: logoPreview || undefined,
        isRoast: selectedType === 'roasted',
      }

      const response = await cartApi.addToCart(cartItem)
      console.log('Add to cart response:', response)

      if (response?.statusCode === 200) {
        // Update cart count
        const cartResponse = await cartApi.getCartItems()
        if (cartResponse?.statusCode === 200 && Array.isArray(cartResponse.data)) {
          setCartItemsCount(cartResponse.data.length)
        }
        if (cartResponse?.statusCode === 200 && Array.isArray(cartResponse.data)) {
          setCartItemsCount(cartResponse.data.length)
        }
        setShowDoneStep(true)
        window.scrollTo({ top: 0, behavior: 'smooth' })
      } else {
        alert(response?.message || 'Failed to add item to cart')
      }
    } catch (error) {
      console.error('Error adding to cart:', error)
      alert('Failed to add item to cart. Please try again.')
    } finally {
      setIsLoading(false)
    }
  }

  // Calculate wholesale amount
  const calculateWholesaleAmount = useCallback(() => {
    const price = parseFloat(bagPrice || '0')
    const qty = parseInt(caseQuantity || '1')
    const total = price * qty
    setAmount(total.toFixed(2))
  }, [bagPrice, caseQuantity])

  // Update wholesale bag size and price
  const updateWholesaleBagSize = useCallback((newBagSize: string) => {
    setBagSize(newBagSize)
    // Update price based on bag size (you can customize this logic)
    const basePrice = parseFloat(String(selectedProductData?.bagPrice || 12.99))
    const wholesaleBagConfigs: { [key: string]: number } = {
      '12oz Retail Bag': basePrice,
      '16oz Retail Bag': basePrice * 1.2,
      '5lb Bag': basePrice * 3.5,
    }
    if (wholesaleBagConfigs[newBagSize]) {
      setBagPrice(wholesaleBagConfigs[newBagSize].toString())
    }
  }, [selectedProductData])

  // Update amount when case quantity or bag price changes
  useEffect(() => {
    if (selectedType === 'wholesale' && selectedWholesaleProduct) {
      calculateWholesaleAmount()
    }
  }, [caseQuantity, bagPrice, selectedType, selectedWholesaleProduct, calculateWholesaleAmount])

  // Handle search
  const handleSearch = async (query: string) => {
    if (!query.trim()) {
      // Reset to original products when search is cleared
      if (selectedType === 'wholesale') {
        setWholesaleProducts(originalWholesaleProducts)
        setWholesalePage(1)
      } else if (selectedCoffeeType === 'single-origin') {
        // Refetch single origin products
        const response = await stockPostingsApi.getStockPostings({
          productType: 'roasted_single_origin'
        })
        if (response?.statusCode === 200) {
          setSingleOriginProducts(response.data || [])
          setCurrentPage(1)
        }
      } else if (selectedCoffeeType === 'blend') {
        // Refetch blend products
        const response = await stockPostingsApi.getStockPostings({
          productType: 'roasted_blend'
        })
        if (response?.statusCode === 200) {
          setBlendProducts(response.data || [])
        }
      }
      return
    }

    try {
      setLoadingProducts(true)
      const response = await stockPostingsApi.searchStockPostings(query)
      if (response?.statusCode === 200) {
        // Update products based on current selection
        if (selectedCoffeeType === 'single-origin') {
          setSingleOriginProducts(response.data || [])
          setCurrentPage(1) // Reset to first page
        } else if (selectedCoffeeType === 'blend') {
          setBlendProducts(response.data || [])
        } else if (selectedType === 'wholesale') {
          setWholesaleProducts(response.data || [])
          setWholesalePage(1) // Reset to first page
        }
      }
    } catch (error) {
      console.error('Error searching products:', error)
    } finally {
      setLoadingProducts(false)
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
          <div className="flex items-center gap-4">
            <Link to="/" className="flex items-center gap-2 z-10 relative">
              <img src={vianextaLogo} alt="ViaNexta" className="h-8" />
            </Link>
            <div className="flex items-center gap-4 z-10 relative ml-4 lg:ml-8">
              {/* User name */}
              {/* User name or Sign In */}
              {isAuthenticated ? (
                <div className="bg-gradient-to-r from-[#09543D] to-[#0d6b4f] rounded-full px-5 py-2.5 shadow-md">
                  <span
                    className="text-white font-medium text-sm lg:text-base tracking-wide"
                    style={{
                      fontFamily: "'Poppins', sans-serif",
                      letterSpacing: '0.5px'
                    }}
                  >
                    Hi, {userProfile?.userFullName || userProfile?.name || userProfile?.firstName || userProfile?.businessName || 'User'}
                  </span>
                </div>
              ) : (
                <Link
                  to="/signin"
                  className="bg-white border-2 border-[#09543D] text-[#09543D] rounded-full px-5 py-2 hover:bg-[#09543D] hover:text-white transition-all duration-200 font-medium"
                >
                  Sign In
                </Link>
              )}

              {/* Dashboard icon */}
              <button
                onClick={() => {
                  setComingSoonFeature('Dashboard')
                  setShowComingSoonModal(true)
                }}
                className="w-11 h-11 lg:w-12 lg:h-12 rounded-full bg-white border-2 border-gray-100 flex items-center justify-center hover:border-[#09543D] hover:bg-[#09543D]/5 transition-all duration-200 shadow-sm hover:shadow-md group"
                aria-label="Dashboard"
              >
                <svg className="w-5 h-5 lg:w-6 lg:h-6 text-gray-600 group-hover:text-[#09543D] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
              </button>

              {/* Cart icon with count */}
              <button
                onClick={() => {
                  fetchCartItems()
                  setShowCart(true)
                }}
                className="relative w-11 h-11 lg:w-12 lg:h-12 rounded-full bg-white border-2 border-gray-100 flex items-center justify-center hover:border-[#09543D] hover:bg-[#09543D]/5 transition-all duration-200 shadow-sm hover:shadow-md group"
                aria-label="Shopping Cart"
              >
                <svg className="w-5 h-5 lg:w-6 lg:h-6 text-gray-600 group-hover:text-[#09543D] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                {cartItemsCount > 0 && (
                  <span className="absolute -top-1 -right-1 bg-[#D8501C] text-white text-xs font-medium rounded-full w-5 h-5 flex items-center justify-center">
                    {cartItemsCount > 9 ? '9+' : cartItemsCount}
                  </span>
                )}
              </button>

              {/* Order history icon */}
              <button
                onClick={() => {
                  setComingSoonFeature('Orders')
                  setShowComingSoonModal(true)
                }}
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

      <div className="h-screen flex flex-col pt-16 lg:pt-0 overflow-hidden">
        {/* Wizard Content - Adjusted for right panel */}
        <div
          className={`flex-1 flex flex-col p-8 lg:p-12 bg-white justify-start items-center overflow-y-auto pt-8 lg:pt-24 relative transition-all duration-300 ${isChatMinimized ? 'mr-0' : 'mr-0 lg:mr-[400px]'
            }`}
        >
          <div className="w-full max-w-6xl">
            {/* Question */}
            <div className="text-center mb-6 lg:mb-8">
              <h1
                className="text-xl sm:text-2xl lg:text-3xl xl:text-4xl font-medium text-gray-900 mb-3 leading-tight"
                style={{
                  fontFamily: "'Poppins', sans-serif",
                  letterSpacing: '1px',
                  lineHeight: '1.1',
                  fontWeight: 500
                }}
              >
                What type of coffee bean
              </h1>
              <h1
                className="text-xl sm:text-2xl lg:text-3xl xl:text-4xl font-medium text-[#09543D] leading-tight"
                style={{
                  fontFamily: "'Poppins', sans-serif",
                  letterSpacing: '1px',
                  lineHeight: '1.1',
                  fontWeight: 500
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
                className={`group relative bg-white rounded-xl border-2 p-4 lg:p-5 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${selectedType === 'roasted'
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
                  className={`text-base lg:text-lg font-medium transition-colors ${selectedType === 'roasted' ? 'text-[#09543D]' : 'text-gray-800'
                    }`}
                  style={{
                    fontFamily: "'Poppins', sans-serif",
                    letterSpacing: '1px',
                    fontWeight: 500
                  }}
                >
                  Roasted
                </h3>
              </button>

              {/* Wholesale Brands Card */}
              <button
                onClick={() => setSelectedType('wholesale')}
                className={`group relative bg-white rounded-xl border-2 p-4 lg:p-5 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${selectedType === 'wholesale'
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
                  className={`text-base lg:text-lg font-medium transition-colors ${selectedType === 'wholesale' ? 'text-[#09543D]' : 'text-gray-800'
                    }`}
                  style={{
                    fontFamily: "'Poppins', sans-serif",
                    letterSpacing: '1px',
                    fontWeight: 500
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
                className={`mt-8 lg:mt-10 transition-all duration-500 ${showCoffeeType ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'
                  }`}
              >
                <h2
                  className="text-xl sm:text-2xl lg:text-3xl font-medium text-gray-900 text-center mb-6 lg:mb-8"
                  style={{
                    fontFamily: "'Poppins', sans-serif",
                    letterSpacing: '1px',
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
                    className={`group relative bg-white rounded-xl border-2 p-4 lg:p-5 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${selectedCoffeeType === 'single-origin'
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
                      className={`text-base lg:text-lg font-medium transition-colors ${selectedCoffeeType === 'single-origin' ? 'text-[#09543D]' : 'text-gray-800'
                        }`}
                      style={{
                        fontFamily: "'Poppins', sans-serif",
                        letterSpacing: '1px'
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
                    className={`group relative bg-white rounded-xl border-2 p-4 lg:p-5 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${selectedCoffeeType === 'blend'
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
                      className={`text-base lg:text-lg font-medium transition-colors ${selectedCoffeeType === 'blend' ? 'text-[#09543D]' : 'text-gray-800'
                        }`}
                      style={{
                        fontFamily: "'Poppins', sans-serif",
                        letterSpacing: '1px'
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
                className={`mt-8 lg:mt-10 transition-all duration-500 ${showWholesaleBrands ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'
                  }`}
              >
                {/* Heading */}
                <h2
                  className="text-xl lg:text-2xl font-medium text-gray-900 text-center mb-6 lg:mb-8"
                  style={{
                    fontFamily: "'Poppins', sans-serif",
                    letterSpacing: '1px'
                  }}
                >
                  Wholesale Brands
                </h2>

                {/* Search Bar */}
                <div className="max-w-md mx-auto mb-6">
                  <div className="relative">
                    <input
                      type="text"
                      value={searchQuery}
                      onChange={(e) => {
                        setSearchQuery(e.target.value)
                        handleSearch(e.target.value)
                      }}
                      placeholder="Search products..."
                      className="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#09543D] focus:outline-none transition-colors"
                    />
                    <svg className="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                  </div>
                </div>

                {/* Loading State */}
                {loadingProducts && (
                  <div className="text-center py-8">
                    <div className="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-[#09543D]"></div>
                    <p className="mt-4 text-gray-600">Loading products...</p>
                  </div>
                )}

                {/* Product Cards Grid */}
                {!loadingProducts && (
                  <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 lg:gap-6 mb-6 max-w-7xl mx-auto">
                    {wholesaleProducts
                      .slice((wholesalePage - 1) * 8, wholesalePage * 8)
                      .map((product: StockPosting) => {
                        const qualityScore = product.scaScoreComponents
                          ? Object.values(product.scaScoreComponents).reduce((sum: number, val: number | undefined) => sum + (val || 0), 0) / 9
                          : 0
                        const originCountry = product.supplierInfo?.billingCountry || 'Unknown'

                        return (
                          <div
                            key={product.id}
                            onClick={() => handleProductSelect(product.id, 'wholesale')}
                            className={`bg-white rounded-xl border-2 p-4 hover:shadow-lg transition-all cursor-pointer ${selectedWholesaleProduct === String(product.id)
                              ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg'
                              : 'border-gray-200 hover:border-[#09543D]'
                              }`}
                          >
                            {/* Coffee Bag Image */}
                            <div className="w-full h-32 bg-gray-100 rounded-lg mb-3 flex items-center justify-center overflow-hidden">
                              {product.imageUrl ? (
                                <img src={product.imageUrl} alt={product.name} className="w-full h-full object-cover" />
                              ) : (
                                <div className="w-full h-full bg-gradient-to-br from-amber-800 via-amber-900 to-amber-950 flex items-center justify-center relative">
                                  {/* Coffee bag representation */}
                                  <div className="w-20 h-24 bg-amber-700 rounded-lg shadow-lg relative">
                                    {/* Circular label on bag */}
                                    <div className="absolute top-2 left-1/2 transform -translate-x-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center">
                                      <div className="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-full"></div>
                                    </div>
                                  </div>
                                </div>
                              )}
                            </div>

                            {/* Product Name */}
                            <h3
                              className="text-sm font-medium text-gray-900 mb-2 uppercase line-clamp-2 text-center"
                              style={{
                                fontFamily: "'Poppins', sans-serif",
                                letterSpacing: '0.8px',
                                fontWeight: 500
                              }}
                            >
                              {product.name || 'Unnamed Product'}
                            </h3>

                            {/* Origin */}
                            <div className="flex items-center justify-center gap-1.5 mb-2 min-w-0">
                              <div className="w-3 h-3 bg-green-500 rounded-sm flex-shrink-0"></div>
                              <span className="text-xs text-gray-600 line-clamp-1">{originCountry}</span>
                            </div>

                            {/* Coffee Type */}
                            <p className="text-[10px] text-gray-600 text-center mb-2">{product.coffeeType || 'Arabica'}</p>

                            {/* Score */}
                            {qualityScore > 0 && (
                              <div className="flex flex-col items-center">
                                <div className="bg-[#09543D] text-white px-2 py-1 rounded text-[10px] font-medium">
                                  {Math.round(qualityScore)}
                                </div>
                                <span className="text-[9px] text-gray-500 mt-0.5">Score</span>
                              </div>
                            )}
                          </div>
                        )
                      })}
                  </div>
                )}

                {/* No Products Message */}
                {!loadingProducts && wholesaleProducts.length === 0 && (
                  <div className="text-center py-8">
                    <p className="text-gray-600">No products found. Try adjusting your search.</p>
                  </div>
                )}

                {/* Pagination */}
                {wholesaleProducts.length > 8 && (
                  <div className="flex flex-col items-center gap-4">
                    {/* Page indicator */}
                    <p
                      className="text-sm text-gray-600"
                      style={{
                        fontFamily: "'Poppins', sans-serif"
                      }}
                    >
                      Page {wholesalePage} of {Math.ceil(wholesaleProducts.length / 8)}
                    </p>

                    {/* Page number buttons */}
                    <div className="flex gap-2">
                      {Array.from({ length: Math.ceil(wholesaleProducts.length / 8) }, (_, i) => i + 1).map((page) => (
                        <button
                          key={page}
                          onClick={() => setWholesalePage(page)}
                          className={`w-10 h-10 rounded-lg font-medium transition-all ${wholesalePage === page
                            ? 'bg-[#09543D] text-white shadow-md'
                            : 'bg-white border border-gray-200 text-gray-700 hover:border-gray-300'
                            }`}
                          style={{
                            fontFamily: "'Poppins', sans-serif",
                            letterSpacing: '0.8px',
                            fontWeight: 500
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
                        className={`px-6 py-2.5 rounded-xl border font-semibold transition-all flex items-center gap-2 ${wholesalePage === 1
                          ? 'bg-gray-100 border-gray-200 text-gray-400 cursor-not-allowed'
                          : 'bg-white border-gray-200 text-gray-700 hover:border-gray-300 hover:bg-gray-50'
                          }`}
                        style={{
                          fontFamily: "'Poppins', sans-serif"
                        }}
                      >
                        <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
                        </svg>
                        Previous
                      </button>
                      <button
                        onClick={() => setWholesalePage(prev => Math.min(Math.ceil(wholesaleProducts.length / 8), prev + 1))}
                        disabled={wholesalePage >= Math.ceil(wholesaleProducts.length / 8)}
                        className={`px-6 py-2.5 rounded-xl border font-semibold transition-all flex items-center gap-2 ${wholesalePage >= Math.ceil(wholesaleProducts.length / 8)
                          ? 'bg-gray-100 border-gray-200 text-gray-400 cursor-not-allowed'
                          : 'bg-white border-[#09543D] text-[#09543D] hover:bg-[#09543D]/5 hover:border-[#09543D]/80'
                          }`}
                        style={{
                          fontFamily: "'Poppins', sans-serif"
                        }}
                      >
                        Next
                        <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                        </svg>
                      </button>
                    </div>
                  </div>
                )}
              </div>
            )}

            {/* Wholesale Product Detail View */}
            {selectedType === 'wholesale' && selectedWholesaleProduct && (
              <div ref={wholesaleProductDetailRef} className="mt-8 lg:mt-10">
                {/* Back Button */}
                <button
                  onClick={() => {
                    setSelectedWholesaleProduct('')
                    setSelectedProductData(null)
                  }}
                  className="mb-6 flex items-center gap-2 text-gray-600 hover:text-[#09543D] transition-colors"
                  style={{
                    fontFamily: "'Poppins', sans-serif"
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
                      {selectedProductData?.imageUrl ? (
                        <img
                          src={selectedProductData.imageUrl}
                          alt={selectedProductData.name || 'Product'}
                          className="w-full h-full max-h-[400px] object-contain rounded-lg"
                        />
                      ) : (
                        <div className="relative">
                          {/* Coffee bag representation */}
                          <div className="w-48 h-64 bg-gradient-to-br from-amber-800 via-amber-900 to-amber-950 rounded-lg shadow-2xl relative">
                            {/* Circular label on bag */}
                            <div className="absolute top-8 left-1/2 transform -translate-x-1/2 w-32 h-32 bg-white rounded-full flex items-center justify-center shadow-lg">
                              <div className="w-28 h-28 bg-gradient-to-br from-[#09543D] to-[#1E4637] rounded-full flex flex-col items-center justify-center text-white p-4 text-center">
                                <div className="text-xs font-medium mb-1">GREENSTREET</div>
                                <div className="text-lg font-medium">{(selectedProductData?.name || selectedWholesaleProduct).split(' ')[0]}</div>
                                <div className="text-xs mt-1">{(selectedProductData?.name || selectedWholesaleProduct).split(' ').slice(1).join(' ')}</div>
                              </div>
                            </div>
                          </div>
                        </div>
                      )}
                    </div>

                    {/* Thumbnail Images */}
                    <div className="grid grid-cols-4 gap-3">
                      {[1, 2, 3, 4].map((thumb) => (
                        <div
                          key={thumb}
                          className="bg-gray-100 rounded-lg p-3 cursor-pointer hover:border-2 hover:border-[#09543D] transition-all"
                        >
                          {selectedProductData?.imageUrl ? (
                            <img
                              src={selectedProductData.imageUrl}
                              alt={`Thumbnail ${thumb}`}
                              className="w-full h-24 object-cover rounded"
                            />
                          ) : (
                            <div className="w-full h-24 bg-gradient-to-br from-amber-800 via-amber-900 to-amber-950 rounded flex items-center justify-center">
                              <div className="w-12 h-16 bg-amber-700 rounded relative">
                                <div className="absolute top-1 left-1/2 transform -translate-x-1/2 w-6 h-6 bg-white rounded-full"></div>
                              </div>
                            </div>
                          )}
                        </div>
                      ))}
                    </div>
                  </div>

                  {/* Right Section - Product Information */}
                  <div>
                    {/* Product Title */}
                    <h2
                      className="text-3xl lg:text-4xl font-medium text-[#09543D] mb-6"
                      style={{
                        fontFamily: "'Poppins', sans-serif",
                        letterSpacing: '1px'
                      }}
                    >
                      {(selectedProductData?.name || selectedProductData?.description || selectedWholesaleProduct)?.toUpperCase()}
                    </h2>

                    {/* Purchase Options */}
                    <div className="space-y-4 mb-6">
                      {/* Bag Size and Bag Price Row */}
                      <div className="grid grid-cols-2 gap-4">
                        <div>
                          <label
                            className="block text-sm font-semibold text-gray-700 mb-2"
                            style={{
                              fontFamily: "'Poppins', sans-serif",
                              letterSpacing: '0.8px',
                              fontWeight: 500
                            }}
                          >
                            Bag Size
                          </label>
                          <select
                            value={bagSize}
                            onChange={(e) => updateWholesaleBagSize(e.target.value)}
                            className="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#09543D] focus:outline-none transition-colors"
                          >
                            <option value="12oz Retail Bag">12oz Retail Bag</option>
                            <option value="16oz Retail Bag">16oz Retail Bag</option>
                            <option value="5lb Bag">5lb Bag</option>
                          </select>
                        </div>
                        <div>
                          <label
                            className="block text-sm font-semibold text-gray-700 mb-2"
                            style={{
                              fontFamily: "'Poppins', sans-serif",
                              letterSpacing: '0.8px',
                              fontWeight: 500
                            }}
                          >
                            Bag Price($)
                          </label>
                          <input
                            type="text"
                            value={bagPrice || '0.00'}
                            readOnly
                            className="w-full px-4 py-3 border-2 border-gray-200 rounded-lg bg-gray-50"
                          />
                        </div>
                      </div>

                      {/* Case Quantity and Amount Row */}
                      <div className="grid grid-cols-2 gap-4">
                        <div>
                          <label
                            className="block text-sm font-semibold text-gray-700 mb-2"
                            style={{
                              fontFamily: "'Poppins', sans-serif",
                              letterSpacing: '0.8px',
                              fontWeight: 500
                            }}
                          >
                            Case Quantity(8 units)
                          </label>
                          <input
                            type="number"
                            min="1"
                            value={caseQuantity}
                            onChange={(e) => {
                              setCaseQuantity(e.target.value)
                              calculateWholesaleAmount()
                            }}
                            className="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#09543D] focus:outline-none transition-colors"
                          />
                        </div>
                        <div>
                          <label
                            className="block text-sm font-semibold text-gray-700 mb-2"
                            style={{
                              fontFamily: "'Poppins', sans-serif",
                              letterSpacing: '0.8px',
                              fontWeight: 500
                            }}
                          >
                            Amount
                          </label>
                          <input
                            type="text"
                            value={`$ ${parseFloat(amount || '0').toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`}
                            readOnly
                            className="w-full px-4 py-3 border-2 border-gray-200 rounded-lg bg-gray-50"
                          />
                        </div>
                      </div>

                      {/* Availability */}
                      <p className="text-sm text-gray-600">
                        {selectedProductData?.quantityLeft || selectedProductData?.quantityPosted || 'N/A'} bags available
                      </p>

                      {/* Proceed Button */}
                      <button
                        onClick={handleAddToCart}
                        disabled={isLoading || !caseQuantity || !selectedProductData}
                        className="w-full bg-[#D8501C] text-white py-4 rounded-lg font-medium text-lg hover:bg-[#b73d1a] transition-colors disabled:opacity-70 disabled:cursor-not-allowed flex items-center justify-center gap-3"
                        style={{
                          fontFamily: "'Poppins', sans-serif",
                          letterSpacing: '0.8px',
                          fontWeight: 500
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
                          'Proceed'
                        )}
                      </button>
                    </div>

                    {/* Product Details Table */}
                    <div className="mt-8">
                      <h3
                        className="text-xl font-medium text-[#09543D] mb-4"
                        style={{
                          fontFamily: "'Poppins', sans-serif",
                          letterSpacing: '0.8px',
                          fontWeight: 500
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
                                  fontFamily: "'Poppins', sans-serif",
                                  letterSpacing: '0.8px',
                                  fontWeight: 500
                                }}
                              >
                                Info
                              </th>
                              <th
                                className="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b border-gray-200"
                                style={{
                                  fontFamily: "'Poppins', sans-serif",
                                  letterSpacing: '0.8px',
                                  fontWeight: 500
                                }}
                              >
                                Description
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr className="border-b border-gray-200">
                              <td className="px-4 py-3 text-sm font-semibold text-gray-700">Vendor</td>
                              <td className="px-4 py-3 text-sm text-[#D8501C] font-semibold">{selectedProductData?.supplierInfo?.firstName || 'N/A'}</td>
                            </tr>
                            <tr className="border-b border-gray-200">
                              <td className="px-4 py-3 text-sm font-semibold text-gray-700">Variety</td>
                              <td className="px-4 py-3 text-sm text-[#D8501C] font-semibold">{selectedProductData?.variety || selectedProductData?.description || 'N/A'}</td>
                            </tr>
                            <tr className="border-b border-gray-200">
                              <td className="px-4 py-3 text-sm font-semibold text-gray-700">Coffee Type</td>
                              <td className="px-4 py-3 text-sm text-[#D8501C] font-semibold">{selectedProductData?.coffeeType || 'Arabica'}</td>
                            </tr>
                            <tr className="border-b border-gray-200">
                              <td className="px-4 py-3 text-sm font-semibold text-gray-700">Quality</td>
                              <td className="px-4 py-3 text-sm text-[#D8501C] font-semibold">
                                {selectedProductData?.scaScoreComponents
                                  ? Math.round(Object.values(selectedProductData.scaScoreComponents).reduce((sum: number, val: number | undefined) => sum + (val || 0), 0) / 9)
                                  : selectedProductData?.quality || 'Premium'}
                              </td>
                            </tr>
                            <tr className="border-b border-gray-200">
                              <td className="px-4 py-3 text-sm font-semibold text-gray-700">Notes</td>
                              <td className="px-4 py-3 text-sm text-[#D8501C] font-semibold">{selectedProductData?.description || selectedProductData?.aroma || 'Balanced, slightly sweet and acidic'}</td>
                            </tr>
                            <tr>
                              <td className="px-4 py-3 text-sm font-semibold text-gray-700">Process</td>
                              <td className="px-4 py-3 text-sm text-[#D8501C] font-semibold">{selectedProductData?.process || 'Pupled Natural and Fully Washed Beans'}</td>
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
                className={`mt-8 lg:mt-10 transition-all duration-500 ${showSingleOrigin ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'
                  }`}
              >
                {/* Heading */}
                <h2
                  className="text-xl lg:text-2xl font-medium text-gray-900 text-center mb-6 lg:mb-8"
                  style={{
                    fontFamily: "'Poppins', sans-serif",
                    letterSpacing: '1px'
                  }}
                >
                  Single origin
                </h2>

                {/* Search Bar */}
                <div className="max-w-md mx-auto mb-6">
                  <div className="relative">
                    <input
                      type="text"
                      value={searchQuery}
                      onChange={(e) => {
                        setSearchQuery(e.target.value)
                        handleSearch(e.target.value)
                      }}
                      placeholder="Search products..."
                      className="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#09543D] focus:outline-none transition-colors"
                    />
                    <svg className="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                  </div>
                </div>

                {/* Loading State */}
                {loadingProducts && (
                  <div className="text-center py-8">
                    <div className="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-[#09543D]"></div>
                    <p className="mt-4 text-gray-600">Loading products...</p>
                  </div>
                )}

                {/* Coffee Cards Grid */}
                {!loadingProducts && (
                  <div className="grid grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-5 mb-6 max-w-7xl mx-auto">
                    {singleOriginProducts
                      .slice((currentPage - 1) * 9, currentPage * 9)
                      .map((product: StockPosting) => {
                        const qualityScore = product.scaScoreComponents
                          ? Object.values(product.scaScoreComponents).reduce((sum: number, val: number | undefined) => sum + (val || 0), 0) / 9
                          : 0
                        const originCountry = product.supplierInfo?.billingCountry || 'Unknown'

                        return (
                          <div
                            key={product.id}
                            onClick={() => handleProductSelect(product.id, 'single-origin')}
                            className={`bg-white rounded-xl border-2 p-4 hover:shadow-lg transition-all cursor-pointer flex flex-col ${selectedCoffee === String(product.id)
                              ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                              : 'border-gray-200 hover:border-[#09543D]'
                              }`}
                          >
                            {/* Coffee Bean Image */}
                            <div className="w-full h-32 lg:h-40 bg-gray-100 rounded-lg mb-3 flex items-center justify-center overflow-hidden flex-shrink-0">
                              {product.imageUrl ? (
                                <img src={product.imageUrl} alt={product.name} className="w-full h-full object-cover" />
                              ) : (
                                <div className="w-16 h-16 bg-gradient-to-br from-green-700 to-green-900 rounded-lg"></div>
                              )}
                            </div>

                            {/* Coffee Name */}
                            <h3
                              className="text-sm lg:text-base font-medium text-gray-900 mb-2 uppercase line-clamp-3 leading-tight flex-grow"
                              style={{
                                fontFamily: "'Poppins', sans-serif",
                                letterSpacing: '0.8px',
                                fontWeight: 500
                              }}
                            >
                              {product.name || 'Unnamed Product'}
                            </h3>

                            {/* Bottom Section */}
                            <div className="flex items-center justify-between mt-auto">
                              {/* Left: Flag and Country */}
                              <div className="flex items-center gap-1.5 min-w-0">
                                <div className="w-3 h-3 bg-green-500 rounded-sm flex-shrink-0"></div>
                                <span className="text-xs text-gray-600 line-clamp-1">{originCountry}</span>
                              </div>

                              {/* Right: Score */}
                              {qualityScore > 0 && (
                                <div className="bg-[#D8501C] text-white px-2 py-1 rounded text-xs font-medium flex-shrink-0">
                                  {Math.round(qualityScore)}
                                </div>
                              )}
                            </div>
                          </div>
                        )
                      })}
                  </div>
                )}

                {/* No Products Message */}
                {!loadingProducts && singleOriginProducts.length === 0 && (
                  <div className="text-center py-8">
                    <p className="text-gray-600">No products found. Try adjusting your search.</p>
                  </div>
                )}

                {/* Pagination */}
                {singleOriginProducts.length > 9 && (
                  <div className="flex flex-col items-center gap-4">
                    {/* Page indicator */}
                    <p
                      className="text-sm text-gray-600"
                      style={{
                        fontFamily: "'Poppins', sans-serif"
                      }}
                    >
                      Page {currentPage} of {Math.ceil(singleOriginProducts.length / 9)}
                    </p>

                    {/* Page number buttons */}
                    <div className="flex gap-2">
                      {Array.from({ length: Math.ceil(singleOriginProducts.length / 9) }, (_, i) => i + 1).map((page) => (
                        <button
                          key={page}
                          onClick={() => setCurrentPage(page)}
                          className={`w-10 h-10 rounded-lg font-medium transition-all ${currentPage === page
                            ? 'bg-[#D8501C] text-white shadow-md'
                            : 'bg-white border border-gray-200 text-gray-700 hover:border-gray-300'
                            }`}
                          style={{
                            fontFamily: "'Poppins', sans-serif",
                            letterSpacing: '0.8px',
                            fontWeight: 500
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
                        className={`px-6 py-2.5 rounded-xl border font-semibold transition-all flex items-center gap-2 ${currentPage === 1
                          ? 'bg-gray-100 border-gray-200 text-gray-400 cursor-not-allowed'
                          : 'bg-white border-gray-200 text-gray-700 hover:border-gray-300 hover:bg-gray-50'
                          }`}
                        style={{
                          fontFamily: "'Poppins', sans-serif"
                        }}
                      >
                        <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
                        </svg>
                        Previous
                      </button>
                      <button
                        onClick={() => setCurrentPage(prev => Math.min(Math.ceil(singleOriginProducts.length / 9), prev + 1))}
                        disabled={currentPage >= Math.ceil(singleOriginProducts.length / 9)}
                        className={`px-6 py-2.5 rounded-xl border font-semibold transition-all flex items-center gap-2 ${currentPage >= Math.ceil(singleOriginProducts.length / 9)
                          ? 'bg-gray-100 border-gray-200 text-gray-400 cursor-not-allowed'
                          : 'bg-white border-[#09543D] text-[#09543D] hover:bg-[#09543D]/5 hover:border-[#09543D]/80'
                          }`}
                        style={{
                          fontFamily: "'Poppins', sans-serif"
                        }}
                      >
                        Next
                        <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                        </svg>
                      </button>
                    </div>
                  </div>
                )}
              </div>
            )}

            {/* Product Selection - For Blend */}
            {selectedCoffeeType === 'blend' && (
              <div
                ref={productSelectionSectionRef}
                className={`mt-8 lg:mt-10 transition-all duration-500 ${showProductSelection ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'
                  }`}
              >
                <h2
                  className="text-xl sm:text-2xl lg:text-3xl font-medium text-gray-900 text-center mb-6 lg:mb-8"
                  style={{
                    fontFamily: "'Poppins', sans-serif",
                    letterSpacing: '1px',
                    lineHeight: '1.1'
                  }}
                >
                  Select Product
                </h2>

                {/* Search Bar */}
                <div className="max-w-md mx-auto mb-6">
                  <div className="relative">
                    <input
                      type="text"
                      value={searchQuery}
                      onChange={(e) => {
                        setSearchQuery(e.target.value)
                        handleSearch(e.target.value)
                      }}
                      placeholder="Search products..."
                      className="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#09543D] focus:outline-none transition-colors"
                    />
                    <svg className="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                  </div>
                </div>

                {/* Loading State */}
                {loadingProducts && (
                  <div className="text-center py-8">
                    <div className="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-[#09543D]"></div>
                    <p className="mt-4 text-gray-600">Loading products...</p>
                  </div>
                )}

                {/* Blend Details View */}
                {selectedProductData && showBlendDetails && (
                  <div className="bg-white rounded-2xl border-2 border-gray-200 p-6 lg:p-8 shadow-lg max-w-4xl mx-auto mb-8">
                    <button
                      onClick={() => setShowBlendDetails(false)}
                      className="mb-6 flex items-center gap-2 text-gray-600 hover:text-[#09543D] transition-colors"
                    >
                      <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
                      </svg>
                      Back to products
                    </button>

                    <div className="flex flex-col md:flex-row gap-8">
                      {/* Product Image */}
                      <div className="w-full md:w-1/3">
                        <div className="bg-gray-100 rounded-xl overflow-hidden shadow-md">
                          {selectedProductData.imageUrl ? (
                            <img src={selectedProductData.imageUrl} alt={selectedProductData.name} className="w-full h-auto object-cover" />
                          ) : (
                            <div className="w-full h-64 bg-gradient-to-br from-green-700 via-green-800 to-green-900 flex items-center justify-center">
                              <div className="grid grid-cols-4 gap-1 p-4">
                                {[...Array(16)].map((_, i) => (
                                  <div key={i} className="w-3 h-3 bg-green-600 rounded-sm"></div>
                                ))}
                              </div>
                            </div>
                          )}
                        </div>
                      </div>

                      {/* Product Info */}
                      <div className="w-full md:w-2/3">
                        <h2 className="text-3xl font-bold text-[#09543D] mb-2" style={{ fontFamily: "'Poppins', sans-serif" }}>
                          {selectedProductData.name}
                        </h2>
                        <div className="flex flex-wrap gap-4 mb-6">
                          <span className="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                            {selectedProductData.coffeeType || 'Blend'}
                          </span>
                          {selectedProductData.process && (
                            <span className="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-semibold">
                              {selectedProductData.process}
                            </span>
                          )}
                        </div>

                        <p className="text-gray-600 mb-6 italic">
                          {selectedProductData.description || "A perfectly balanced blend crafted for exceptional taste."}
                        </p>

                        {/* SCA Score Table */}
                        {selectedProductData.scaScoreComponents && (
                          <div className="mb-6">
                            <h3 className="text-lg font-semibold text-gray-800 mb-3">SCA Score Breakdown</h3>
                            <div className="grid grid-cols-2 sm:grid-cols-3 gap-3">
                              {Object.entries(selectedProductData.scaScoreComponents).map(([key, value]: [string, number | undefined]) => (
                                <div key={key} className="bg-gray-50 p-3 rounded-lg border border-gray-100 text-center">
                                  <span className="block text-xs uppercase text-gray-500 mb-1">{key}</span>
                                  <span className="block text-xl font-bold text-[#D8501C]">{Number(value).toFixed(1)}</span>
                                </div>
                              ))}
                            </div>
                          </div>
                        )}

                        <button
                          onClick={() => {
                            // Proceed to Roast Selection
                            setTimeout(() => {
                              roastTypeSectionRef.current?.scrollIntoView({ behavior: 'smooth', block: 'start' })
                            }, 100)
                          }}
                          className="w-full bg-[#D8501C] text-white py-3 rounded-xl font-bold text-lg hover:bg-[#b73d1a] transition-all shadow-md hover:shadow-lg flex justify-center items-center gap-2"
                        >
                          Select Roast
                          <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                          </svg>
                        </button>
                      </div>
                    </div>
                  </div>
                )}

                {/* Product Cards Grid */}
                {!loadingProducts && !showBlendDetails && (
                  <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 max-w-4xl mx-auto">
                    {blendProducts.map((product: StockPosting) => {
                      const qualityScore = product.scaScoreComponents
                        ? Object.values(product.scaScoreComponents).reduce((sum: number, val: number | undefined) => sum + (val || 0), 0) / 9
                        : 0
                      const originCountry = product.supplierInfo?.billingCountry || 'Unknown'

                      return (
                        <button
                          key={product.id}
                          onClick={() => {
                            handleProductSelect(product.id, 'blend')
                            setShowBlendDetails(true)
                            setTimeout(() => {
                              productSelectionSectionRef.current?.scrollIntoView({ behavior: 'smooth', block: 'start' })
                            }, 100)
                          }}
                          className={`group relative bg-white rounded-xl border-2 p-4 lg:p-5 transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${selectedProduct === String(product.id)
                            ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                            : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-lg'
                            }`}
                        >
                          {/* Selection indicator */}
                          {selectedProduct === String(product.id) && (
                            <div className="absolute top-2 right-2 w-5 h-5 bg-[#09543D] rounded-full flex items-center justify-center z-10">
                              <svg className="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3} d="M5 13l4 4L19 7" />
                              </svg>
                            </div>
                          )}

                          {/* Product Image */}
                          <div className="w-full h-40 bg-gray-100 rounded-lg mb-3 flex items-center justify-center overflow-hidden">
                            {product.imageUrl ? (
                              <img src={product.imageUrl} alt={product.name} className="w-full h-full object-cover" />
                            ) : (
                              <div className="w-full h-full bg-gradient-to-br from-green-700 via-green-800 to-green-900 flex items-center justify-center">
                                <div className="grid grid-cols-4 gap-1 p-4">
                                  {[...Array(16)].map((_, i) => (
                                    <div key={i} className="w-3 h-3 bg-green-600 rounded-sm"></div>
                                  ))}
                                </div>
                              </div>
                            )}
                          </div>

                          {/* Product Name */}
                          <h3
                            className={`text-sm lg:text-base font-medium text-gray-900 mb-2 uppercase text-center ${selectedProduct === String(product.id) ? 'text-[#09543D]' : ''
                              }`}
                            style={{
                              fontFamily: "'Poppins', sans-serif",
                              letterSpacing: '0.8px',
                              fontWeight: 500
                            }}
                          >
                            {product.name || 'Unnamed Product'}
                          </h3>

                          {/* Origin */}
                          <div className="flex items-center justify-center gap-2 mb-2">
                            <div className="w-4 h-4 bg-green-500 rounded-sm"></div>
                            <span className="text-xs text-gray-600">{originCountry}</span>
                          </div>

                          {/* Coffee Type */}
                          <p className="text-xs text-gray-600 text-center mb-3">{product.coffeeType || 'Arabica'}</p>

                          {/* Score */}
                          {qualityScore > 0 && (
                            <div className="flex flex-col items-center">
                              <div className="bg-[#D8501C] text-white px-3 py-1.5 rounded-lg text-sm font-medium">
                                {Math.round(qualityScore)}
                              </div>
                              <span className="text-xs text-gray-500 mt-1">Score</span>
                            </div>
                          )}
                        </button>
                      )
                    })}
                  </div>
                )}

                {/* No Products Message */}
                {!loadingProducts && blendProducts.length === 0 && (
                  <div className="text-center py-8">
                    <p className="text-gray-600">No products found. Try adjusting your search.</p>
                  </div>
                )}
              </div>
            )}

            {/* Roast Type Selection */}
            {(selectedCoffee || selectedProduct) && (
              <div
                ref={roastTypeSectionRef}
                className={`mt-8 lg:mt-10 transition-all duration-500 ${showRoastType ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'
                  }`}
              >
                <h2
                  className="text-xl sm:text-2xl lg:text-3xl font-medium text-gray-900 text-center mb-6 lg:mb-8"
                  style={{
                    fontFamily: "'Poppins', sans-serif",
                    letterSpacing: '1px',
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
                    className={`group relative bg-white rounded-xl border-2 p-3 lg:p-4 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${selectedRoastType === 'light'
                      ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                      : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-lg'
                      }`}
                  >
                    {/* Info Icon */}
                    <button
                      onClick={(e) => {
                        e.stopPropagation()
                        setActiveInfoModal({
                          title: 'Light Roast',
                          content: 'Light color, balanced flavor profile with moderate acidity, and subtle sweetness. Well-rounded taste with a medium body.',
                          image: lightRoastIcon
                        })
                      }}
                      className="absolute top-2 left-2 w-6 h-6 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-full flex items-center justify-center transition-colors z-20 shadow-sm"
                    >
                      <span className="text-xs font-serif font-bold italic text-gray-600">i</span>
                    </button>
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
                      className={`text-sm lg:text-base font-medium transition-colors ${selectedRoastType === 'light' ? 'text-[#09543D]' : 'text-gray-800'
                        }`}
                      style={{
                        fontFamily: "'Poppins', sans-serif",
                        letterSpacing: '1px'
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
                    className={`group relative bg-white rounded-xl border-2 p-3 lg:p-4 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${selectedRoastType === 'medium'
                      ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                      : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-lg'
                      }`}
                  >
                    {/* Info Icon */}
                    <button
                      onClick={(e) => {
                        e.stopPropagation()
                        setActiveInfoModal({
                          title: 'Medium Roast',
                          content: 'Medium color, balanced flavor profile with moderate acidity, and subtle sweetness. Well-rounded taste with a medium body.',
                          image: mediumRoastIcon
                        })
                      }}
                      className="absolute top-2 left-2 w-6 h-6 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-full flex items-center justify-center transition-colors z-20 shadow-sm"
                    >
                      <span className="text-xs font-serif font-bold italic text-gray-600">i</span>
                    </button>
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
                      className={`text-sm lg:text-base font-medium transition-colors ${selectedRoastType === 'medium' ? 'text-[#09543D]' : 'text-gray-800'
                        }`}
                      style={{
                        fontFamily: "'Poppins', sans-serif",
                        letterSpacing: '1px'
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
                    className={`group relative bg-white rounded-xl border-2 p-3 lg:p-4 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${selectedRoastType === 'medium-dark'
                      ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                      : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-lg'
                      }`}
                  >
                    {/* Info Icon */}
                    <button
                      onClick={(e) => {
                        e.stopPropagation()
                        setActiveInfoModal({
                          title: 'Medium-Dark Roast',
                          content: 'Medium color, balanced flavor profile with moderate acidity, and subtle sweetness. Well-rounded taste with a medium body.',
                          image: mediumDarkRoastIcon
                        })
                      }}
                      className="absolute top-2 left-2 w-6 h-6 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-full flex items-center justify-center transition-colors z-20 shadow-sm"
                    >
                      <span className="text-xs font-serif font-bold italic text-gray-600">i</span>
                    </button>
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
                      className={`text-sm lg:text-base font-medium transition-colors ${selectedRoastType === 'medium-dark' ? 'text-[#09543D]' : 'text-gray-800'
                        }`}
                      style={{
                        fontFamily: "'Poppins', sans-serif",
                        letterSpacing: '1px'
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
                    className={`group relative bg-white rounded-xl border-2 p-3 lg:p-4 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${selectedRoastType === 'dark'
                      ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                      : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-lg'
                      }`}
                  >
                    {/* Info Icon */}
                    <button
                      onClick={(e) => {
                        e.stopPropagation()
                        setActiveInfoModal({
                          title: 'Dark Roast',
                          content: 'Dark color, balanced flavor profile with moderate acidity, and subtle sweetness. Well-rounded taste with a medium body.',
                          image: darkRoastIcon
                        })
                      }}
                      className="absolute top-2 left-2 w-6 h-6 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-full flex items-center justify-center transition-colors z-20 shadow-sm"
                    >
                      <span className="text-xs font-serif font-bold italic text-gray-600">i</span>
                    </button>
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
                      className={`text-sm lg:text-base font-medium transition-colors ${selectedRoastType === 'dark' ? 'text-[#09543D]' : 'text-gray-800'
                        }`}
                      style={{
                        fontFamily: "'Poppins', sans-serif",
                        letterSpacing: '1px'
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
                className={`mt-8 lg:mt-10 transition-all duration-500 ${showGrindType ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'
                  }`}
              >
                <h2
                  className="text-xl sm:text-2xl lg:text-3xl font-medium text-gray-900 text-center mb-6 lg:mb-8"
                  style={{
                    fontFamily: "'Poppins', sans-serif",
                    letterSpacing: '1px',
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
                    className={`group relative bg-white rounded-xl border-2 p-3 lg:p-4 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${selectedGrindType === 'whole-bean'
                      ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                      : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-lg'
                      }`}
                  >
                    {/* Info Icon */}
                    <button
                      onClick={(e) => {
                        e.stopPropagation()
                        setActiveInfoModal({
                          title: 'Whole Bean',
                          content: 'Whole bean coffee can be used in a variety of brewing methods, including drip coffee makers, pour-over & espresso machine',
                          image: lightRoastIcon
                        })
                      }}
                      className="absolute top-2 left-2 w-6 h-6 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-full flex items-center justify-center transition-colors z-20 shadow-sm"
                    >
                      <span className="text-xs font-serif font-bold italic text-gray-600">i</span>
                    </button>
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
                      className={`text-sm lg:text-base font-medium transition-colors ${selectedGrindType === 'whole-bean' ? 'text-[#09543D]' : 'text-gray-800'
                        }`}
                      style={{
                        fontFamily: "'Poppins', sans-serif",
                        letterSpacing: '1px'
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
                    className={`group relative bg-white rounded-xl border-2 p-3 lg:p-4 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${selectedGrindType === 'coarse'
                      ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                      : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-lg'
                      }`}
                  >
                    {/* Info Icon */}
                    <button
                      onClick={(e) => {
                        e.stopPropagation()
                        setActiveInfoModal({
                          title: 'Coarse',
                          content: 'Ideal for French press and cold brew methods, providing a robust flavor and hearty texture.',
                          image: lightRoastIcon
                        })
                      }}
                      className="absolute top-2 left-2 w-6 h-6 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-full flex items-center justify-center transition-colors z-20 shadow-sm"
                    >
                      <span className="text-xs font-serif font-bold italic text-gray-600">i</span>
                    </button>
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
                      className={`text-sm lg:text-base font-medium transition-colors ${selectedGrindType === 'coarse' ? 'text-[#09543D]' : 'text-gray-800'
                        }`}
                      style={{
                        fontFamily: "'Poppins', sans-serif",
                        letterSpacing: '1px'
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
                    className={`group relative bg-white rounded-xl border-2 p-3 lg:p-4 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${selectedGrindType === 'medium'
                      ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                      : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-lg'
                      }`}
                  >
                    {/* Info Icon */}
                    <button
                      onClick={(e) => {
                        e.stopPropagation()
                        setActiveInfoModal({
                          title: 'Medium',
                          content: 'Suitable for drip coffee makers and pour-over methods, balancing between extraction and flavor clarity.',
                          image: mediumRoastIcon
                        })
                      }}
                      className="absolute top-2 left-2 w-6 h-6 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-full flex items-center justify-center transition-colors z-20 shadow-sm"
                    >
                      <span className="text-xs font-serif font-bold italic text-gray-600">i</span>
                    </button>
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
                      className={`text-sm lg:text-base font-medium transition-colors ${selectedGrindType === 'medium' ? 'text-[#09543D]' : 'text-gray-800'
                        }`}
                      style={{
                        fontFamily: "'Poppins', sans-serif",
                        letterSpacing: '1px'
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
                    className={`group relative bg-white rounded-xl border-2 p-3 lg:p-4 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${selectedGrindType === 'fine'
                      ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                      : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-lg'
                      }`}
                  >
                    {/* Info Icon */}
                    <button
                      onClick={(e) => {
                        e.stopPropagation()
                        setActiveInfoModal({
                          title: 'Fine',
                          content: 'Perfect for espresso machines, maximizing surface area for intense extraction and rich crema.',
                          image: mediumDarkRoastIcon
                        })
                      }}
                      className="absolute top-2 left-2 w-6 h-6 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-full flex items-center justify-center transition-colors z-20 shadow-sm"
                    >
                      <span className="text-xs font-serif font-bold italic text-gray-600">i</span>
                    </button>
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
                      className={`text-sm lg:text-base font-medium transition-colors ${selectedGrindType === 'fine' ? 'text-[#09543D]' : 'text-gray-800'
                        }`}
                      style={{
                        fontFamily: "'Poppins', sans-serif",
                        letterSpacing: '1px'
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
                    className={`group relative bg-white rounded-xl border-2 p-3 lg:p-4 text-center transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${selectedGrindType === 'extra-fine'
                      ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                      : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-lg'
                      }`}
                  >
                    {/* Info Icon */}
                    <button
                      onClick={(e) => {
                        e.stopPropagation()
                        setActiveInfoModal({
                          title: 'Extra Fine',
                          content: 'Used in Turkish coffee preparation, creating a smooth and velvety texture with a strong flavor profile.',
                          image: darkRoastIcon
                        })
                      }}
                      className="absolute top-2 left-2 w-6 h-6 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-full flex items-center justify-center transition-colors z-20 shadow-sm"
                    >
                      <span className="text-xs font-serif font-bold italic text-gray-600">i</span>
                    </button>
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
                      className={`text-sm lg:text-base font-medium transition-colors ${selectedGrindType === 'extra-fine' ? 'text-[#09543D]' : 'text-gray-800'
                        }`}
                      style={{
                        fontFamily: "'Poppins', sans-serif",
                        letterSpacing: '1px'
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
                className={`mt-8 lg:mt-10 transition-all duration-500 w-full ${showPackageSize ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'
                  }`}
              >
                <h2
                  className="text-xl sm:text-2xl lg:text-3xl font-medium text-gray-900 text-center mb-8 lg:mb-10"
                  style={{
                    fontFamily: "'Poppins', sans-serif",
                    letterSpacing: '1px',
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
                        className={`relative text-center p-4 lg:p-5 rounded-xl border-2 transition-all duration-300 transform hover:scale-[1.02] ${selectedPackageSize === pkg.id
                          ? 'border-[#09543D] bg-gradient-to-br from-[#09543D]/10 to-[#09543D]/5 shadow-lg shadow-[#09543D]/10'
                          : 'border-gray-200 hover:border-[#09543D]/50 hover:shadow-md bg-white'
                          }`}
                      >
                        <h3
                          className={`font-medium text-sm lg:text-base transition-colors ${selectedPackageSize === pkg.id ? 'text-[#09543D]' : 'text-gray-800'
                            }`}
                          style={{
                            fontFamily: "'Poppins', sans-serif",
                            letterSpacing: '1px',
                            fontWeight: 500
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
                            <button
                              onClick={(e) => {
                                e.preventDefault()
                                e.stopPropagation()
                                handleLogoDelete()
                              }}
                              className="w-6 h-6 bg-red-500 rounded-full flex items-center justify-center hover:bg-red-600 transition-colors"
                              title="Delete logo"
                            >
                              <svg className="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                              </svg>
                            </button>
                          </div>
                        )}
                      </div>
                      <input
                        ref={logoInputRef}
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
                          className="text-2xl lg:text-3xl font-medium text-gray-900 mb-2"
                          style={{
                            fontFamily: "'Poppins', sans-serif",
                            letterSpacing: '1px',
                            fontWeight: 500
                          }}
                        >
                          {selectedPackage.name}
                        </h3>
                        <p className="text-gray-500 text-sm">Customize your packaging</p>
                      </div>

                      {/* Bag Image Preview with Logo Overlay */}
                      <div className="flex flex-col items-center gap-4">
                        <div
                          className="relative"
                          style={{
                            minWidth: '300px',
                            minHeight: selectedPackageSize === '5lb' ? '500px' : selectedPackageSize === 'kcup' ? '300px' : selectedPackageSize === 'frac' ? '380px' : '400px',
                            width: '300px',
                            height: selectedPackageSize === '5lb' ? '500px' : selectedPackageSize === 'kcup' ? '300px' : selectedPackageSize === 'frac' ? '380px' : '400px',
                            display: 'flex',
                            alignItems: 'center',
                            justifyContent: 'center',
                            background: '#f8f9fa',
                            borderRadius: '16px',
                            padding: '20px',
                            margin: '0 auto',
                            position: 'relative'
                          }}
                        >
                          {/* Main Bag Image */}
                          {selectedPreviewImage || currentBagImage ? (
                            <img
                              src={selectedPreviewImage || currentBagImage}
                              alt="Coffee bag preview"
                              className="preview-img"
                              style={{
                                maxWidth: '100%',
                                maxHeight: '100%',
                                width: 'auto',
                                height: 'auto',
                                objectFit: 'contain',
                                borderRadius: '16px'
                              }}
                              onError={(e) => {
                                // Fallback if image fails to load
                                console.error('Failed to load bag image:', selectedPreviewImage || currentBagImage)
                                const target = e.target as HTMLImageElement
                                target.style.display = 'none'
                              }}
                            />
                          ) : (
                            <div className="flex items-center justify-center h-full text-gray-400">
                              <div className="text-center">
                                <svg className="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p className="text-sm">Bag preview</p>
                              </div>
                            </div>
                          )}

                          {/* Logo Overlay - Only show for non-K-cup bags */}
                          {logoPreview && selectedPackageSize !== 'kcup' && (
                            <div
                              className="absolute"
                              style={{
                                top: 0,
                                left: 0,
                                width: '100%',
                                height: '100%',
                                pointerEvents: 'none',
                                zIndex: 5
                              }}
                            >
                              <img
                                src={logoPreview}
                                alt="Your logo"
                                className="design-image"
                                style={{
                                  position: 'absolute',
                                  objectFit: 'contain',
                                  pointerEvents: 'auto',
                                  ...(selectedPackageSize === '5lb' ? {
                                    top: '42%',
                                    left: '50%',
                                    transform: 'translateX(-50%)',
                                    maxWidth: '450px',
                                    maxHeight: '210px'
                                  } : selectedPackageSize === '12oz' ? {
                                    top: '48%',
                                    left: '50%',
                                    transform: 'translateX(-50%)',
                                    maxWidth: '280px',
                                    maxHeight: '150px'
                                  } : selectedPackageSize === '10oz' ? {
                                    top: '65%',
                                    left: '50%',
                                    transform: 'translateX(-50%)',
                                    maxWidth: '250px',
                                    maxHeight: '150px'
                                  } : selectedPackageSize === 'frac' ? {
                                    top: '40%',
                                    left: '50%',
                                    transform: 'translateX(-50%)',
                                    maxWidth: '130px',
                                    maxHeight: '120px'
                                  } : {
                                    top: '48%',
                                    left: '50%',
                                    transform: 'translateX(-50%)',
                                    maxWidth: '280px',
                                    maxHeight: '150px'
                                  })
                                }}
                              />
                            </div>
                          )}
                        </div>

                        {/* Preview Thumbnails */}
                        {bagPreviewImages.length > 0 && (
                          <div className="flex gap-2 justify-center">
                            {bagPreviewImages.map((img, index) => (
                              <button
                                key={index}
                                onClick={() => setSelectedPreviewImage(img)}
                                className={`w-16 h-16 rounded-lg border-2 overflow-hidden transition-all ${selectedPreviewImage === img || (index === 0 && !selectedPreviewImage)
                                  ? 'border-[#09543D] ring-2 ring-[#09543D]/20'
                                  : 'border-gray-200 hover:border-[#09543D]/50'
                                  }`}
                              >
                                <img
                                  src={img}
                                  alt={`Preview ${index + 1}`}
                                  className="w-full h-full object-cover"
                                />
                              </button>
                            ))}
                          </div>
                        )}
                      </div>
                    </div>
                  )}

                  {/* Details and Quantity Card - Full Width */}
                  {selectedPackageSize && selectedPackage && (
                    <div className="bg-white rounded-2xl border-2 border-gray-200 p-6 lg:p-8 shadow-lg">
                      {/* Bag Details */}
                      <div className="mb-6">
                        <h4
                          className="text-lg font-medium text-gray-800 mb-4"
                          style={{
                            fontFamily: "'Poppins', sans-serif",
                            letterSpacing: '0.8px',
                            fontWeight: 500
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

                      {/* Frac Pack Size Selection */}
                      {selectedPackageSize === 'frac' && (
                        <div className="mb-6 pb-6 border-b border-gray-200">
                          <label
                            className="block text-sm font-medium text-gray-700 mb-3"
                            style={{
                              fontFamily: "'Poppins', sans-serif",
                              letterSpacing: '0.8px',
                              fontWeight: 500
                            }}
                          >
                            Select size:
                          </label>
                          <div className="flex gap-4">
                            <label className="flex items-center gap-2 cursor-pointer">
                              <input
                                type="radio"
                                name="fracPackSize"
                                value="3oz"
                                checked={fracPackSize === '3oz'}
                                onChange={(e) => setFracPackSize(e.target.value)}
                                className="w-5 h-5 text-[#09543D] focus:ring-[#09543D]"
                              />
                              <span className="text-gray-700 font-semibold">3oz</span>
                            </label>
                            <label className="flex items-center gap-2 cursor-pointer">
                              <input
                                type="radio"
                                name="fracPackSize"
                                value="4oz"
                                checked={fracPackSize === '4oz'}
                                onChange={(e) => setFracPackSize(e.target.value)}
                                className="w-5 h-5 text-[#09543D] focus:ring-[#09543D]"
                              />
                              <span className="text-gray-700 font-semibold">4oz</span>
                            </label>
                          </div>
                        </div>
                      )}

                      {/* Quantity Input */}
                      <div>
                        <label
                          className="block text-sm font-medium text-gray-700 mb-3"
                          style={{
                            fontFamily: "'Poppins', sans-serif",
                            letterSpacing: '0.8px',
                            fontWeight: 500
                          }}
                        >
                          <span className="flex items-center gap-2">
                            <svg className="w-5 h-5 text-[#09543D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            QUANTITY (# OF BAGS) *
                          </span>
                        </label>
                        <p className="text-sm text-gray-500 mb-2">Enter the number of bags you'd like to order</p>
                        <input
                          type="number"
                          min="1"
                          value={quantity}
                          onChange={(e) => setQuantity(e.target.value)}
                          placeholder="Enter quantity"
                          className="w-full px-4 py-3.5 border-2 border-[#D8501C]/50 rounded-xl focus:outline-none focus:border-[#D8501C] focus:ring-2 focus:ring-[#D8501C]/20 transition-all text-lg font-semibold"
                          style={{
                            fontFamily: "'Poppins', sans-serif",
                            letterSpacing: '0.8px',
                            fontWeight: 500
                          }}
                        />
                        {/* Amount Display for Regular Products */}
                        {selectedType !== 'wholesale' && quantity && parseFloat(quantity) > 0 && (
                          <div className="mt-3">
                            {!selectedPackageSize && (
                              <p className="text-xs text-amber-600 mb-1">
                                * Please select a package size for accurate pricing
                              </p>
                            )}
                            <div className="text-right">
                              <span className="text-sm text-gray-600">Amount: </span>
                              <span className="text-lg font-medium text-[#09543D]">
                                ${parseFloat(productAmount || '0').toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                              </span>
                            </div>
                          </div>
                        )}
                      </div>

                      {/* Confirm and Proceed Button */}
                      <div className="mt-6 pt-6 border-t border-gray-200">
                        <button
                          onClick={handleAddToCart}
                          disabled={isLoading || !quantity || !selectedProductData}
                          className="w-full px-6 py-4 bg-[#09543D] text-white rounded-xl font-medium text-lg hover:bg-[#0d6b4f] transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-[1.02] disabled:opacity-70 disabled:cursor-not-allowed disabled:transform-none flex items-center justify-center gap-3"
                          style={{
                            fontFamily: "'Poppins', sans-serif",
                            letterSpacing: '0.8px',
                            fontWeight: 500
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
                    className="text-3xl lg:text-4xl font-medium text-gray-900 mb-4"
                    style={{
                      fontFamily: "'Poppins', sans-serif",
                      letterSpacing: '1px'
                    }}
                  >
                    {notificationType === 'payment' ? 'Order Successful!' : 'All Done'}
                  </h3>

                  {/* Message */}
                  <p className="text-gray-600 text-lg mb-6">
                    {notificationType === 'payment'
                      ? 'Your order has been placed successfully. Thank you for your purchase!'
                      : 'Item added to cart successfully. Proceed to checkout to complete your order.'}
                  </p>

                  {/* Action Buttons */}
                  <div className="flex flex-col gap-3">
                    <button
                      onClick={() => {
                        setShowNotification(false)
                        if (notificationType === 'cart') {
                          // Fetch cart items and show cart modal instead of navigating
                          fetchCartItems()
                          setShowCart(true)
                        } else {
                          navigate('/')
                        }
                      }}
                      className="w-full px-8 py-3 bg-[#09543D] text-white rounded-xl font-medium hover:bg-[#0d6b4f] transition-all duration-200 shadow-lg hover:shadow-xl"
                      style={{
                        fontFamily: "'Poppins', sans-serif"
                      }}
                    >
                      {notificationType === 'payment' ? 'Return to Home' : 'View Cart'}
                    </button>

                    <button
                      onClick={() => setShowNotification(false)}
                      className="w-full px-8 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition-all duration-200"
                      style={{
                        fontFamily: "'Poppins', sans-serif"
                      }}
                    >
                      Continue Shopping
                    </button>
                  </div>
                </div>
              </div>
            </div>
          )}

          {/* Cart Modal */}
          {showCart && (
            <div
              className="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
              onClick={() => setShowCart(false)}
            >
              <div
                className="bg-white rounded-2xl p-6 lg:p-8 max-w-2xl w-full shadow-2xl transform transition-all max-h-[90vh] flex flex-col"
                onClick={(e) => e.stopPropagation()}
              >
                <div className="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
                  <h3
                    className="text-2xl lg:text-3xl font-medium text-gray-900"
                    style={{
                      fontFamily: "'Poppins', sans-serif",
                      letterSpacing: '1px'
                    }}
                  >
                    Your Cart ({cartItemsList.length})
                  </h3>
                  <button
                    onClick={() => setShowCart(false)}
                    className="p-2 hover:bg-gray-100 rounded-full transition-colors"
                  >
                    <svg className="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </div>

                {loadingCartItems ? (
                  <div className="flex-1 flex justify-center items-center py-12">
                    <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-[#09543D]"></div>
                  </div>
                ) : cartItemsList.length > 0 ? (
                  <>
                    <div className="flex-1 overflow-y-auto pr-2 space-y-4 mb-6">
                      {cartItemsList.map((item: CartItem, index: number) => {
                        const stockPosting = (item.stockPosting as StockPosting) || ({} as StockPosting)
                        const isWholesale = stockPosting.productType === 'whole_sale_brand'

                        // Calculate price (logic matching Checkout.tsx)
                        let itemPrice = 0
                        let packageDisplay = stockPosting.bagWeight ? `${stockPosting.bagWeight} lb` : ''

                        if (isWholesale) {
                          let basePrice = parseFloat(String(stockPosting.bagPrice || 0))
                          if (item.bagSize === '16oz Retail Bag') basePrice *= 1.2
                          else if (item.bagSize === '5lb Bag') basePrice *= 3.5
                          itemPrice = basePrice * (item.numBags || 0)
                          packageDisplay = item.bagSize || 'Case'
                        } else {
                          let weight = 0.75
                          if (item.bagSize === '5lb') weight = 5
                          else if (item.bagSize === '12oz') weight = 0.75
                          else if (item.bagSize === '10oz') weight = 0.625
                          else if (item.bagSize === 'kcup') weight = 0.75
                          else if (item.bagSize?.startsWith('frac_pack')) {
                            weight = item.bagSize.includes('3oz') ? 0.1875 : 0.25
                          } else if (stockPosting.bagWeight) {
                            weight = parseFloat(String(stockPosting.bagWeight))
                          }

                          let spotPrice = parseFloat(String(stockPosting.spotPrice || stockPosting.spot_price || stockPosting.price || '0'))
                          if (spotPrice === 0 && stockPosting.bagPrice && stockPosting.bagWeight) {
                            const bgPrice = parseFloat(String(stockPosting.bagPrice)) || 0
                            const bgWeight = parseFloat(String(stockPosting.bagWeight)) || 1
                            spotPrice = bgWeight > 0 ? bgPrice / bgWeight : 0
                          }
                          itemPrice = (item.numBags || 0) * (spotPrice * weight)
                          packageDisplay = item.bagSize
                            ? (item.bagSize === 'frac' ? `Frac Pack (${item.bagSize.replace('frac_pack_', '')})` : item.bagSize)
                            : '12oz'
                        }

                        return (
                          <div key={index} className="flex gap-4 p-4 rounded-xl border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all bg-gray-50/50">
                            <div className="w-20 h-20 bg-white rounded-lg border border-gray-200 overflow-hidden flex-shrink-0 p-2">
                              <img
                                src={item.bagImage || stockPosting.imgUrl || vianextaLogo}
                                alt={stockPosting.productName || 'Coffee Product'}
                                className="w-full h-full object-contain"
                              />
                            </div>
                            <div className="flex-1 min-w-0">
                              <h4 className="font-semibold text-gray-900 truncate">
                                {stockPosting.productName || 'Roasted Coffee'}
                              </h4>
                              <p className="text-sm text-gray-500 mb-1 line-clamp-1">
                                {isWholesale
                                  ? `${stockPosting.originCountry || ''} ${stockPosting.process || ''}`.trim()
                                  : `${stockPosting.originCountry || 'Blend'} - ${stockPosting.process || 'Light Roast'}`
                                }
                              </p>
                              <div className="flex flex-wrap gap-2 mt-2">
                                <span className="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-[#1A4D3A]/10 text-[#1A4D3A]">
                                  {packageDisplay}
                                </span>
                                <span className="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                  Qty: {item.numBags || 1}
                                </span>
                              </div>
                            </div>
                            <div className="text-right flex flex-col justify-between">
                              <span className="font-bold text-[#1A4D3A] text-lg">
                                ${itemPrice.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                              </span>
                            </div>
                          </div>
                        )
                      })}
                    </div>

                    <div className="border-t border-gray-100 pt-6 mt-auto">
                      <div className="flex justify-between items-center mb-6">
                        <span className="text-gray-600 font-medium">Total Est.</span>
                        <span className="text-2xl font-bold text-[#1A4D3A]">
                          ${cartItemsList.reduce((sum, item) => {
                            // Quick recalculate for total (ideal to use same function but keeping inline for brevity)
                            const stockPostingItem = (item.stockPosting as StockPosting) || ({} as StockPosting)
                            let price = 0
                            if (stockPostingItem.productType === 'whole_sale_brand') {
                              let base = parseFloat(String(stockPostingItem.bagPrice || 0))
                              if (item.bagSize === '16oz Retail Bag') base *= 1.2
                              else if (item.bagSize === '5lb Bag') base *= 3.5
                              price = base * (item.numBags || 0)
                            } else {
                              let w = 0.75
                              if (item.bagSize === '5lb') w = 5
                              else if (item.bagSize === '12oz') w = 0.75
                              else if (item.bagSize === '10oz') w = 0.625
                              else if (item.bagSize?.startsWith('frac')) w = item.bagSize.includes('3oz') ? 0.1875 : 0.25
                              else if (stockPostingItem.bagWeight) w = parseFloat(String(stockPostingItem.bagWeight))

                              let s = parseFloat(String(stockPostingItem.spotPrice || stockPostingItem.spot_price || stockPostingItem.price || '0'))
                              if (s === 0 && stockPostingItem.bagPrice && stockPostingItem.bagWeight) {
                                s = (parseFloat(String(stockPostingItem.bagPrice)) || 0) / (parseFloat(String(stockPostingItem.bagWeight)) || 1)
                              }
                              price = (item.numBags || 0) * (s * w)
                            }
                            return sum + price
                          }, 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                        </span>
                      </div>

                      <div className="grid grid-cols-2 gap-4">
                        <button
                          onClick={() => setShowCart(false)}
                          className="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition-all duration-200"
                        >
                          Keep Shopping
                        </button>
                        <button
                          onClick={() => navigate('/checkout')}
                          className="px-6 py-3 bg-[#D8501C] text-white rounded-xl font-medium hover:bg-[#b73d1a] transition-all duration-200 shadow-lg hover:shadow-xl"
                        >
                          Proceed to Checkout
                        </button>
                      </div>
                    </div>
                  </>
                ) : (
                  <div className="flex-1 flex flex-col justify-center items-center py-12 text-center">
                    <div className="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                      <svg className="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                      </svg>
                    </div>
                    <h4 className="text-xl font-medium text-gray-900 mb-2">Your cart is empty</h4>
                    <p className="text-gray-500 mb-8">Looks like you haven't added any coffee yet.</p>
                    <button
                      onClick={() => setShowCart(false)}
                      className="px-8 py-3 bg-[#09543D] text-white rounded-xl font-medium hover:bg-[#0d6b4f] transition-all duration-200"
                    >
                      Start Shopping
                    </button>
                  </div>
                )}
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
                  {/* Title */}
                  <h3
                    className="text-3xl lg:text-4xl font-medium text-gray-900 mb-4"
                    style={{
                      fontFamily: "'Poppins', sans-serif",
                      letterSpacing: '1px'
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
                      className="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-medium hover:bg-gray-300 transition-all duration-200"
                      style={{
                        fontFamily: "'Poppins', sans-serif"
                      }}
                    >
                      Cancel
                    </button>
                    <button
                      onClick={() => {
                        setShowLogoutConfirm(false)
                        navigate('/signin')
                      }}
                      className="px-6 py-3 bg-red-600 text-white rounded-xl font-medium hover:bg-red-700 transition-all duration-200 shadow-lg hover:shadow-xl"
                      style={{
                        fontFamily: "'Poppins', sans-serif"
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

      {/* Clare Side Panel */}
      <ClareSidePanel
        isMinimized={isChatMinimized}
        onToggle={setIsChatMinimized}
      />
      {/* Info Modal */}
      {activeInfoModal && (
        <div className="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm animate-in fade-in duration-200">
          <div className="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl transform transition-all scale-100">
            <div className="flex justify-between items-start mb-4">
              <h3 className="text-xl font-bold text-gray-900 font-placard">{activeInfoModal.title}</h3>
              <button
                onClick={() => setActiveInfoModal(null)}
                className="p-1 hover:bg-gray-100 rounded-full transition-colors"
              >
                <svg className="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>

            <div className="flex flex-col items-center text-center">
              <div className="w-24 h-24 mb-4 p-2 bg-gray-50 rounded-full flex items-center justify-center">
                <img src={activeInfoModal.image} alt={activeInfoModal.title} className="w-16 h-16 object-contain" />
              </div>
              <div className="w-full h-px bg-gray-100 my-4"></div>
              <p className="text-gray-600 leading-relaxed text-lg">
                {activeInfoModal.content}
              </p>
            </div>

            <div className="mt-8">
              <button
                onClick={() => setActiveInfoModal(null)}
                className="w-full py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-xl transition-colors"
              >
                Close
              </button>
            </div>
          </div>
        </div>
      )}

      {/* Done Step Overlay */}
      {showDoneStep && (
        <div className="fixed inset-0 z-[50] flex flex-col items-center justify-center bg-white animate-in fade-in duration-300">
          <div className="text-center p-8 max-w-lg w-full">
            <div className="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-8 animate-bounce">
              <svg className="w-12 h-12 text-[#09543D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3} d="M5 13l4 4L19 7" />
              </svg>
            </div>

            <h2 className="text-4xl font-bold text-[#09543D] mb-4" style={{ fontFamily: "'Poppins', sans-serif" }}>
              All Done!
            </h2>
            <p className="text-xl text-gray-600 mb-10">
              Your item has been successfully added to the cart.
            </p>

            <div className="space-y-4">
              <button
                onClick={() => {
                  setShowDoneStep(false)
                  fetchCartItems()
                  setShowCart(true)
                }}
                className="w-full bg-[#09543D] text-white py-4 rounded-xl font-bold text-lg hover:bg-[#07402E] transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1 block"
              >
                Proceed to Checkout
              </button>

              <button
                onClick={() => {
                  setShowDoneStep(false)
                  // Reset selections for new shopping
                  setSelectedType('')
                }}
                className="w-full bg-white border-2 border-gray-200 text-gray-700 py-4 rounded-xl font-bold text-lg hover:border-[#09543D] hover:text-[#09543D] transition-all block"
              >
                Continue Shopping
              </button>
            </div>
          </div>
        </div>
      )}

      {/* Coming Soon Modal */}
      {showComingSoonModal && (
        <div
          className="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
          onClick={() => setShowComingSoonModal(false)}
        >
          <div
            className="bg-white rounded-2xl p-6 lg:p-8 max-w-md w-full shadow-2xl transform transition-all"
            onClick={(e) => e.stopPropagation()}
          >
            <div className="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
              <h3
                className="text-2xl lg:text-3xl font-medium text-gray-900"
                style={{
                  fontFamily: "'Poppins', sans-serif",
                  letterSpacing: '1px'
                }}
              >
                Coming Soon
              </h3>
              <button
                onClick={() => setShowComingSoonModal(false)}
                className="p-2 hover:bg-gray-100 rounded-full transition-colors"
              >
                <svg className="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>

            <div className="text-center py-8">
              <div className="mb-6">
                <svg className="w-20 h-20 mx-auto text-[#09543D] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
              </div>
              <p className="text-lg text-gray-700 mb-2 font-semibold">
                {comingSoonFeature} is coming soon!
              </p>
              <p className="text-sm text-gray-500">
                We're working hard to bring you an amazing {comingSoonFeature.toLowerCase()} experience. Stay tuned!
              </p>
            </div>

            <div className="mt-6">
              <button
                onClick={() => setShowComingSoonModal(false)}
                className="w-full bg-[#09543D] text-white py-4 rounded-xl font-bold text-lg hover:bg-[#07382F] transition-all"
              >
                Got it
              </button>
            </div>
          </div>
        </div>
      )}
    </div>
  )
}

export default BuyerWizard

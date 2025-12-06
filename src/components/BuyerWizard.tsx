import { useState, useRef, useEffect, useCallback } from 'react'
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
import { stockPostingsApi, cartApi, wholesaleApi } from '../utils/api'

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
  
  // API Data States
  const [singleOriginProducts, setSingleOriginProducts] = useState<any[]>([])
  const [blendProducts, setBlendProducts] = useState<any[]>([])
  const [wholesaleProducts, setWholesaleProducts] = useState<any[]>([])
  const [originalWholesaleProducts, setOriginalWholesaleProducts] = useState<any[]>([]) // Store original for search reset
  const [wholesaleBrands, setWholesaleBrands] = useState<any[]>([])
  const [filterOptions, setFilterOptions] = useState<any>(null)
  const [selectedProductData, setSelectedProductData] = useState<any>(null)
  const [loadingProducts, setLoadingProducts] = useState(false)
  const [searchQuery, setSearchQuery] = useState('')
  const [cartItemsCount, setCartItemsCount] = useState(0)
  const [currentBagImage, setCurrentBagImage] = useState<string>('')
  
  // Bag image mapping based on package size - using local images from public folder
  const bagImageMap: { [key: string]: string } = {
    '5lb': '/images/buyer/5lb_1.jpg',
    '12oz': '/images/buyer/12oz_1.png',
    '10oz': '/images/buyer/10oz_1.png',
    'frac': '/images/buyer/frac_pack.png',
    'kcup': '/images/buyer/kcup.jpg',
  }
  
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
  const logoInputRef = useRef<HTMLInputElement>(null)

  // Fetch products and filter options on mount
  useEffect(() => {
    const fetchInitialData = async () => {
      try {
        setLoadingProducts(true)
        
        // Fetch filter options
        const filterResponse = await stockPostingsApi.getFilterOptions()
        if (filterResponse?.statusCode === 200) {
          setFilterOptions(filterResponse.data)
        }

        // Fetch cart items count
        const cartResponse = await cartApi.getCartItems()
        if (cartResponse?.statusCode === 200 && Array.isArray(cartResponse.data)) {
          setCartItemsCount(cartResponse.data.length)
        }
      } catch (error) {
        console.error('Error fetching initial data:', error)
      } finally {
        setLoadingProducts(false)
      }
    }

    fetchInitialData()
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
            setWholesaleBrands(brandsResponse.data || [])
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
    if (selectedType !== 'wholesale' && quantity && selectedProductData && selectedPackageSize) {
      const qty = parseFloat(quantity) || 0
      const spotPrice = parseFloat(selectedProductData.spotPrice || selectedProductData.price || '0') || 0
      const bagWeight = packageWeightMap[selectedPackageSize] || 1
      
      // For regular products: quantity * (spot_price * bag_weight)
      // This matches the web version calculation: quantity * (spot_price * package_size)
      const total = qty * (spotPrice * bagWeight)
      setProductAmount(total.toFixed(2))
    } else {
      setProductAmount('0.00')
    }
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
      if (response?.statusCode === 200) {
        // Update cart count
        const cartResponse = await cartApi.getCartItems()
        if (cartResponse?.statusCode === 200 && Array.isArray(cartResponse.data)) {
          setCartItemsCount(cartResponse.data.length)
        }
        setShowNotification(true)
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
    const wholesaleBagConfigs: { [key: string]: number } = {
      '12oz Retail Bag': selectedProductData?.bagPrice || 12.99,
      '16oz Retail Bag': (selectedProductData?.bagPrice || 12.99) * 1.2,
      '5lb Bag': (selectedProductData?.bagPrice || 12.99) * 3.5,
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

              {/* Cart icon with count */}
              <button 
                className="relative w-11 h-11 lg:w-12 lg:h-12 rounded-full bg-white border-2 border-gray-100 flex items-center justify-center hover:border-[#09543D] hover:bg-[#09543D]/5 transition-all duration-200 shadow-sm hover:shadow-md group"
                aria-label="Shopping Cart"
              >
                <svg className="w-5 h-5 lg:w-6 lg:h-6 text-gray-600 group-hover:text-[#09543D] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                {cartItemsCount > 0 && (
                  <span className="absolute -top-1 -right-1 bg-[#D8501C] text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                    {cartItemsCount > 9 ? '9+' : cartItemsCount}
                  </span>
                )}
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
                <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-5 mb-6">
                    {wholesaleProducts
                  .slice((wholesalePage - 1) * 8, wholesalePage * 8)
                      .map((product: any) => {
                        const qualityScore = product.scaScoreComponents 
                          ? Object.values(product.scaScoreComponents).reduce((sum: number, val: any) => sum + (val || 0), 0) / 9
                          : 0
                        const originCountry = product.supplierInfo?.billingCountry || 'Unknown'
                        
                        return (
                          <div
                            key={product.id}
                            onClick={() => handleProductSelect(product.id, 'wholesale')}
                      className={`bg-white rounded-xl border-2 p-3 hover:shadow-lg transition-all cursor-pointer ${
                              selectedWholesaleProduct === String(product.id)
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
                        className="text-xs font-bold text-gray-900 mb-2 uppercase truncate text-center"
                        style={{
                          fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                        }}
                      >
                              {product.name || 'Unnamed Product'}
                      </h3>

                      {/* Origin */}
                      <div className="flex items-center justify-center gap-1.5 mb-2">
                        <div className="w-3 h-3 bg-green-500 rounded-sm"></div>
                              <span className="text-[10px] text-gray-600 truncate">{originCountry}</span>
                      </div>

                      {/* Coffee Type */}
                            <p className="text-[10px] text-gray-600 text-center mb-2">{product.coffeeType || 'Arabica'}</p>

                      {/* Score */}
                            {qualityScore > 0 && (
                      <div className="flex flex-col items-center">
                        <div className="bg-[#09543D] text-white px-2 py-1 rounded text-[10px] font-bold">
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
                      fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
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
                        onClick={() => setWholesalePage(prev => Math.min(Math.ceil(wholesaleProducts.length / 8), prev + 1))}
                        disabled={wholesalePage >= Math.ceil(wholesaleProducts.length / 8)}
                      className={`px-6 py-2.5 rounded-xl border font-semibold transition-all flex items-center gap-2 ${
                          wholesalePage >= Math.ceil(wholesaleProducts.length / 8)
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
                              <div className="text-xs font-bold mb-1">GREENSTREET</div>
                                <div className="text-lg font-bold">{(selectedProductData?.name || selectedWholesaleProduct).split(' ')[0]}</div>
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
                      className="text-3xl lg:text-4xl font-bold text-[#09543D] mb-6"
                      style={{
                        fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                        letterSpacing: '-1px'
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
                            fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
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
                              fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
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
                              fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
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
                            fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
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
                        className="w-full bg-[#D8501C] text-white py-4 rounded-lg font-bold text-lg hover:bg-[#b73d1a] transition-colors disabled:opacity-70 disabled:cursor-not-allowed flex items-center justify-center gap-3"
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
                          'Proceed'
                        )}
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
                                  ? Math.round(Object.values(selectedProductData.scaScoreComponents).reduce((sum: number, val: any) => sum + (val || 0), 0) / 9)
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
                  <div className="grid grid-cols-4 lg:grid-cols-5 gap-3 lg:gap-4 mb-6 max-w-6xl mx-auto">
                    {singleOriginProducts
                      .slice((currentPage - 1) * 9, currentPage * 9)
                      .map((product: any) => {
                        const qualityScore = product.scaScoreComponents 
                          ? Object.values(product.scaScoreComponents).reduce((sum: number, val: any) => sum + (val || 0), 0) / 9
                          : 0
                        const originCountry = product.supplierInfo?.billingCountry || 'Unknown'
                        
                        return (
                          <div
                            key={product.id}
                            onClick={() => handleProductSelect(product.id, 'single-origin')}
                            className={`bg-white rounded-xl border-2 p-4 hover:shadow-lg transition-all cursor-pointer flex flex-col ${
                              selectedCoffee === String(product.id)
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
                              className="text-sm lg:text-base font-bold text-gray-900 mb-2 uppercase line-clamp-2 leading-tight flex-grow"
                        style={{
                          fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
                        }}
                      >
                              {product.name || 'Unnamed Product'}
                      </h3>

                      {/* Bottom Section */}
                            <div className="flex items-center justify-between mt-auto">
                        {/* Left: Flag and Country */}
                        <div className="flex items-center gap-1.5">
                                <div className="w-3 h-3 bg-green-500 rounded-sm flex-shrink-0"></div>
                                <span className="text-xs text-gray-600 truncate">{originCountry}</span>
                        </div>

                        {/* Right: Score */}
                              {qualityScore > 0 && (
                                <div className="bg-[#D8501C] text-white px-2 py-1 rounded text-xs font-bold flex-shrink-0">
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
                      fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
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
                      onClick={() => setCurrentPage(prev => Math.min(Math.ceil(singleOriginProducts.length / 9), prev + 1))}
                      disabled={currentPage >= Math.ceil(singleOriginProducts.length / 9)}
                      className={`px-6 py-2.5 rounded-xl border font-semibold transition-all flex items-center gap-2 ${
                        currentPage >= Math.ceil(singleOriginProducts.length / 9)
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
                )}
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

                {/* Product Cards */}
                {!loadingProducts && (
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 max-w-4xl mx-auto">
                    {blendProducts.map((product: any) => {
                      const qualityScore = product.scaScoreComponents 
                        ? Object.values(product.scaScoreComponents).reduce((sum: number, val: any) => sum + (val || 0), 0) / 9
                        : 0
                      const originCountry = product.supplierInfo?.billingCountry || 'Unknown'
                      
                      return (
                    <button
                      key={product.id}
                      onClick={() => {
                            handleProductSelect(product.id, 'blend')
                        setTimeout(() => {
                          roastTypeSectionRef.current?.scrollIntoView({ behavior: 'smooth', block: 'start' })
                        }, 100)
                      }}
                      className={`group relative bg-white rounded-xl border-2 p-4 lg:p-5 transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-1 ${
                            selectedProduct === String(product.id)
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
                        className={`text-sm lg:text-base font-bold text-gray-900 mb-2 uppercase text-center ${
                              selectedProduct === String(product.id) ? 'text-[#09543D]' : ''
                        }`}
                        style={{
                          fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
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
                        <div className="bg-[#D8501C] text-white px-3 py-1.5 rounded-lg text-sm font-bold">
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
                                className={`w-16 h-16 rounded-lg border-2 overflow-hidden transition-all ${
                                  selectedPreviewImage === img || (index === 0 && !selectedPreviewImage)
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

                          {/* Frac Pack Size Selection */}
                          {selectedPackageSize === 'frac' && (
                            <div className="mb-6 pb-6 border-b border-gray-200">
                              <label 
                                className="block text-sm font-bold text-gray-700 mb-3"
                                style={{
                                  fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif"
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
                            <p className="text-sm text-gray-500 mb-2">Enter the number of bags you'd like to order</p>
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
                            {/* Amount Display for Regular Products */}
                            {selectedType !== 'wholesale' && quantity && parseFloat(quantity) > 0 && (
                              <div className="mt-3 text-right">
                                <span className="text-sm text-gray-600">Amount: </span>
                                <span className="text-lg font-bold text-[#09543D]">
                                  ${parseFloat(productAmount).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                                </span>
                              </div>
                            )}
                          </div>

                          {/* Confirm and Proceed Button */}
                          <div className="mt-6 pt-6 border-t border-gray-200">
                            <button
                              onClick={handleAddToCart}
                              disabled={isLoading || !quantity || !selectedProductData}
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

import { useState } from 'react'
import illustrationLeft from '../../assets/illustration-left.svg'
import buyLeftIllustration from '../../assets/buy-left-illustration.svg'
import illustrationRight from '../../assets/illustration-right.svg'
import buyRightIllustration from '../../assets/buy-right-illustration.svg'
import dashesLeft from '../../assets/dashes-left.svg'
import dashesRight from '../../assets/dashes-right.svg'

interface HeroProps {
  onBuyClick: () => void
  onBuildClick: () => void
}

function Hero({ onBuyClick, onBuildClick }: HeroProps) {
  const [activeTab, setActiveTab] = useState<'build' | 'buy'>('build')


  return (
    <section className={`${activeTab === 'buy' ? 'bg-[#09543D]' : 'bg-[#F9F7F1]'} mt-[65px] py-8 lg:mt-[73px] lg:py-20 relative overflow-hidden transition-colors duration-300`}>
      {/* Left dashed line - Desktop only */}
      <div className="absolute left-0 top-1/2 -translate-y-1/2 -translate-y-28 translate-x-64 hidden lg:block" style={{ zIndex: 1 }}>
        <img src={dashesLeft} alt="Left dashed line" className="h-auto w-60" />
      </div>

      {/* Right dashed line - Desktop only */}
      <div className="absolute right-0 top-1/2 -translate-y-1/2 -translate-x-80 hidden lg:block" style={{ zIndex: 1 }}>
        <img src={dashesRight} alt="Right dashed line" className="h-auto w-64" />
      </div>

      {/* Mobile: Right Illustration (Shopping Bag) - Top Right */}
      <div className="absolute right-4 top-4 lg:hidden" style={{ zIndex: 2 }}>
        <img src={activeTab === 'buy' ? buyRightIllustration : illustrationRight} alt="Right illustration" className="h-auto w-24" />
      </div>

      {/* Mobile: Tabs */}
      <div className="absolute left-4 md:left-1/2 md:-translate-x-1/2 lg:hidden" style={{ zIndex: 10, bottom: '5rem', pointerEvents: 'auto' }}>
        <div className="inline-flex gap-2 p-2 rounded-full bg-white" style={{ pointerEvents: 'auto' }}>
          <button
            onClick={() => {
              setActiveTab('build')
              onBuildClick()
            }}
            className={`px-4 py-3 rounded-full font-medium text-sm transition-all ${activeTab === 'build'
              ? 'bg-[#09543D] text-white hover:opacity-90'
              : 'text-[#09543D] bg-white hover:bg-[#09543D] hover:text-white'
              }`}
            style={{ pointerEvents: 'auto', position: 'relative', zIndex: 11 }}
          >
            I want to build a brand
          </button>
          <button
            onClick={() => {
              setActiveTab('buy')
              onBuyClick()
            }}
            className={`px-4 py-3 rounded-full font-medium text-sm transition-all ${activeTab === 'buy'
              ? 'bg-[#09543D] text-white hover:opacity-90'
              : 'text-[#09543D] bg-white hover:bg-[#09543D] hover:text-white'
              }`}
            style={{ pointerEvents: 'auto', position: 'relative', zIndex: 11 }}
          >
            I want to sell products
          </button>
        </div>
      </div>

      {/* Desktop: Left Illustration */}
      <div className="absolute left-12 top-1/2 hidden lg:block" style={{ zIndex: 2, transform: activeTab === 'buy' ? 'translateY(-1rem)' : 'translateY(2rem)' }}>
        <img src={activeTab === 'buy' ? buyLeftIllustration : illustrationLeft} alt="Left illustration" className="h-auto w-72" />
      </div>

      {/* Desktop: Right Illustration */}
      <div className="absolute right-20 top-1/2 -translate-y-64 hidden lg:block" style={{ zIndex: 2 }}>
        <img src={activeTab === 'buy' ? buyRightIllustration : illustrationRight} alt="Right illustration" className="h-auto w-56" />
      </div>

      <div className="container mx-auto px-4 relative" style={{ zIndex: 3 }}>
        {/* Mobile Layout */}
        <div className="lg:hidden pt-28 pb-20" style={{ pointerEvents: 'auto' }}>
          {/* Main Heading - Centered on mobile */}
          <h1
            key={activeTab}
            className="split text-6xl font-bold mb-6 text-center mt-4"
            style={{
              fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
              letterSpacing: '-1.3px',
              color: activeTab === 'buy' ? '#FFFFFF' : '#09543D',
              lineHeight: '0.9'
            }}
          >
            {activeTab === 'buy' ? (
              <>
                <span>GET QUALITY</span>
                <br />
                <span className="relative inline-block">
                  <span className="relative z-10" style={{ color: '#09543D' }}>PRODUCTS FOR</span>
                  <span
                    className="absolute inset-0 bg-[#D2FA52] -z-10"
                    style={{
                      transform: 'skewX(-12deg)',
                      transformOrigin: 'left center',
                      top: '-0.25rem',
                      bottom: '-0.25rem',
                      left: '-1rem',
                      right: '-1rem'
                    }}
                  ></span>
                </span>
                <br />
                <span>YOUR BUSINESS</span>
                <br />
                <span className="relative inline-block">
                  FAST
                  <span
                    className="absolute bottom-0 left-0 right-0 h-2 bg-[#D2FA52] -z-10"
                    style={{
                      transform: 'skewX(-2deg)',
                      bottom: '-0.1rem'
                    }}
                  ></span>
                </span>
              </>
            ) : (
              <>
                <span>LAUNCH YOUR</span>
                <br />
                <span className="relative inline-block">
                  <span className="relative z-10">PRODUCT LINE</span>
                  <span
                    className="absolute inset-0 bg-[#D2FA52] -z-10"
                    style={{
                      transform: 'skewX(-12deg)',
                      transformOrigin: 'left center',
                      top: '-0.25rem',
                      bottom: '-0.25rem',
                      left: '-1rem',
                      right: '-1rem'
                    }}
                  ></span>
                </span>
                <br />
                <span className="relative inline-block">
                  IN MINUTES
                  <span
                    className="absolute bottom-0 left-0 right-0 h-2 bg-[#D2FA52] -z-10"
                    style={{
                      transform: 'skewX(-2deg)',
                      bottom: '-0.1rem'
                    }}
                  ></span>
                </span>
              </>
            )}
          </h1>

          {/* Descriptive Paragraph - Centered beneath title on mobile */}
          <div className="mt-8 mb-12 text-center px-4">
            <p className={`text-sm leading-relaxed ${activeTab === 'buy' ? 'text-white' : 'text-gray-800'}`}>
              {activeTab === 'buy'
                ? 'Wholesale-ready products, ethically sourced and reliably delivered without managing suppliers, inventory chaos, or long lead times.'
                : "From sourcing raw ingredients to final packaging. ViaNexta's builds your entire supply chain, connecting you with verified global partners instantly."}
            </p>
          </div>
        </div>

        {/* Desktop Layout */}
        <div className="hidden lg:block max-w-4xl mx-auto text-center">
          {/* Main Heading */}
          <h1
            key={activeTab}
            className="split text-6xl md:text-7xl lg:text-8xl font-bold mb-6"
            style={{
              fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
              letterSpacing: '-1.3px',
              color: activeTab === 'buy' ? '#FFFFFF' : '#09543D',
              lineHeight: '0.9'
            }}
          >
            {activeTab === 'buy' ? (
              <>
                <span>GET QUALITY</span>
                <br />
                <span className="relative inline-block">
                  <span className="relative z-10" style={{ color: '#09543D' }}>PRODUCTS FOR</span>
                  <span
                    className="absolute inset-0 bg-[#D2FA52] -z-10"
                    style={{
                      transform: 'skewX(-12deg)',
                      transformOrigin: 'left center',
                      top: '-0.25rem',
                      bottom: '-0.25rem',
                      left: '-1rem',
                      right: '-1rem'
                    }}
                  ></span>
                </span>
                <br />
                <span>YOUR BUSINESS</span>
                <br />
                <span>FAST</span>
              </>
            ) : (
              <>
                <span>LAUNCH YOUR</span>
                <br />
                <span className="relative inline-block">
                  <span className="relative z-10">PRODUCT LINE</span>
                  <span
                    className="absolute inset-0 bg-[#D2FA52] -z-10"
                    style={{
                      transform: 'skewX(-12deg)',
                      transformOrigin: 'left center',
                      top: '-0.25rem',
                      bottom: '-0.25rem',
                      left: '-1rem',
                      right: '-1rem'
                    }}
                  ></span>
                </span>
                <br />
                <span>IN MINUTES</span>
              </>
            )}
          </h1>

          {/* Descriptive Paragraph */}
          <p className={`text-lg md:text-xl mb-10 max-w-2xl mx-auto ${activeTab === 'buy' ? 'text-white' : 'text-gray-800'}`}>
            {activeTab === 'buy'
              ? 'Wholesale-ready products, ethically sourced and reliably delivered without managing suppliers, inventory chaos, or long lead times.'
              : <>
                From sourcing raw ingredients to final packaging.<br />
                ViaNexta's builds your entire supply chain,<br />
                connecting you with verified global partners instantly.
              </>}
          </p>

          {/* Call-to-Action Buttons */}
          <div className={`inline-flex gap-2 p-2 rounded-full ${activeTab === 'buy' ? 'bg-white' : 'bg-white'}`}>
            <button
              onClick={() => {
                setActiveTab('build')
                onBuildClick()
              }}
              className={`px-8 py-3 rounded-full font-medium transition-all ${activeTab === 'build'
                ? 'bg-[#09543D] text-white hover:opacity-90'
                : 'text-[#09543D] bg-white hover:bg-[#09543D] hover:text-white'
                }`}
            >
              I want to build a brand
            </button>
            <button
              onClick={() => {
                setActiveTab('buy')
                onBuyClick()
              }}
              className={`px-8 py-3 rounded-full font-medium transition-all ${activeTab === 'buy'
                ? 'bg-[#09543D] text-white hover:opacity-90'
                : 'text-[#09543D] bg-white hover:bg-[#09543D] hover:text-white'
                }`}
            >
              I want to sell products
            </button>
          </div>
        </div>
      </div>
    </section>
  )
}

export default Hero


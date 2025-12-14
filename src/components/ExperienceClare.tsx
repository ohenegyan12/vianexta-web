import gifNormal from '../../assets/gif-normal.mp4'

interface ExperienceClareProps {
  isBuyMode: boolean
}

function ExperienceClare({ isBuyMode }: ExperienceClareProps) {




  return (
    <section id="experience-clare"
      className="relative py-20 md:py-32"
      style={{
        background: isBuyMode
          ? 'linear-gradient(to bottom, #09543D 0%, #09543D 50%, #F9F7F1 50%, #F9F7F1 100%)'
          : '#F9F7F1'
      }}
    >
      <div className="container mx-auto px-4">
        <div className="flex flex-col items-center">
          {/* Title */}
          <h2
            className="font-bold mb-8 md:mb-12 text-center overflow-hidden"
            style={{
              fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
              letterSpacing: '-1.3px',
              lineHeight: '0.9',
              color: isBuyMode ? '#FFFFFF' : '#09543D'
            }}
          >
            <span className="block text-5xl md:text-6xl lg:text-7xl xl:text-8xl">
              EXPERIENCE CLARE
            </span>
          </h2>

          {/* Video */}
          <div className="w-full max-w-4xl">
            <video
              src={gifNormal}
              autoPlay
              loop
              muted
              playsInline
              className="w-full h-auto rounded-2xl shadow-lg"
            />
          </div>
        </div>
      </div>
    </section>
  )
}

export default ExperienceClare


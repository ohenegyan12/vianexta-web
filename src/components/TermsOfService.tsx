import { Link } from 'react-router-dom'
import buyLogo from '../../assets/buy-logo.svg'
import ChatButton from './ChatButton'

function TermsOfService() {
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
              Clear Terms, Transparent Service
            </h1>
            <p className="text-lg text-white mb-8 leading-relaxed">
              Our terms of service outline the rules and regulations for using ViaNexta. We believe in fair, transparent agreements that protect both you and us.
            </p>
            
            {/* Feature Points */}
            <div className="space-y-4 mb-8">
              <div className="flex items-start gap-3">
                <div className="w-6 h-6 rounded-full bg-white flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg className="w-4 h-4 text-[#1E4637]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p className="text-white">Fair and transparent terms</p>
              </div>
              <div className="flex items-start gap-3">
                <div className="w-6 h-6 rounded-full bg-white flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg className="w-4 h-4 text-[#1E4637]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p className="text-white">Clear service expectations</p>
              </div>
              <div className="flex items-start gap-3">
                <div className="w-6 h-6 rounded-full bg-white flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg className="w-4 h-4 text-[#1E4637]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p className="text-white">Protection for all parties</p>
              </div>
              <div className="flex items-start gap-3">
                <div className="w-6 h-6 rounded-full bg-white flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg className="w-4 h-4 text-[#1E4637]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p className="text-white">Easy to understand language</p>
              </div>
            </div>

            {/* Additional Info */}
            <div className="mt-8 pt-8 border-t border-white/20">
              <p className="text-white/90 text-sm leading-relaxed">
                By using ViaNexta, you agree to these terms. Please read them carefully to understand your rights and responsibilities.
              </p>
            </div>
          </div>
        </div>

        {/* Right Section - Terms of Service Content */}
        <div className="flex-1 lg:w-1/2 flex flex-col p-8 lg:p-12 bg-white items-center pt-8 lg:pt-12 overflow-y-auto">
          <div className="w-full max-w-2xl">
            <h2 
              className="text-4xl font-bold mb-2"
              style={{
                fontFamily: "'Placard Next', 'Arial Black', 'Arial Bold', Arial, sans-serif",
                color: '#09543D',
                letterSpacing: '-1px'
              }}
            >
              Terms of Service
            </h2>
            <p className="text-gray-600 mb-8">
              Last updated: {new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}
            </p>

            <div className="prose prose-sm max-w-none space-y-6 text-gray-700">
              <section>
                <h3 className="text-xl font-semibold text-gray-900 mb-3">1. Acceptance of Terms</h3>
                <p className="leading-relaxed">
                  By accessing and using ViaNexta, you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to these terms, please do not use our service.
                </p>
              </section>

              <section>
                <h3 className="text-xl font-semibold text-gray-900 mb-3">2. Description of Service</h3>
                <p className="leading-relaxed">
                  ViaNexta provides a platform that connects businesses with verified manufacturers, suppliers, and partners for supply chain management. Our services include sourcing, logistics coordination, and supply chain optimization tools.
                </p>
              </section>

              <section>
                <h3 className="text-xl font-semibold text-gray-900 mb-3">3. User Accounts</h3>
                <p className="leading-relaxed mb-3">To access certain features, you must create an account. You agree to:</p>
                <ul className="list-disc list-inside space-y-2 ml-4">
                  <li>Provide accurate and complete information</li>
                  <li>Maintain and update your account information</li>
                  <li>Keep your password secure and confidential</li>
                  <li>Notify us immediately of any unauthorized use</li>
                  <li>Accept responsibility for all activities under your account</li>
                </ul>
              </section>

              <section>
                <h3 className="text-xl font-semibold text-gray-900 mb-3">4. Use of Service</h3>
                <p className="leading-relaxed mb-3">You agree to use our service only for lawful purposes and in accordance with these terms. You agree not to:</p>
                <ul className="list-disc list-inside space-y-2 ml-4">
                  <li>Violate any applicable laws or regulations</li>
                  <li>Infringe upon the rights of others</li>
                  <li>Transmit harmful or malicious code</li>
                  <li>Interfere with or disrupt the service</li>
                  <li>Attempt to gain unauthorized access</li>
                </ul>
              </section>

              <section>
                <h3 className="text-xl font-semibold text-gray-900 mb-3">5. Intellectual Property</h3>
                <p className="leading-relaxed">
                  All content, features, and functionality of ViaNexta are owned by us and are protected by international copyright, trademark, and other intellectual property laws. You may not reproduce, distribute, or create derivative works without our express written permission.
                </p>
              </section>

              <section>
                <h3 className="text-xl font-semibold text-gray-900 mb-3">6. Payment Terms</h3>
                <p className="leading-relaxed mb-3">For paid services:</p>
                <ul className="list-disc list-inside space-y-2 ml-4">
                  <li>Payment is due as specified in your service agreement</li>
                  <li>All fees are non-refundable unless otherwise stated</li>
                  <li>We reserve the right to change our pricing with notice</li>
                  <li>You are responsible for any applicable taxes</li>
                </ul>
              </section>

              <section>
                <h3 className="text-xl font-semibold text-gray-900 mb-3">7. Limitation of Liability</h3>
                <p className="leading-relaxed">
                  To the maximum extent permitted by law, ViaNexta shall not be liable for any indirect, incidental, special, consequential, or punitive damages, or any loss of profits or revenues, whether incurred directly or indirectly.
                </p>
              </section>

              <section>
                <h3 className="text-xl font-semibold text-gray-900 mb-3">8. Indemnification</h3>
                <p className="leading-relaxed">
                  You agree to indemnify and hold harmless ViaNexta from any claims, damages, losses, liabilities, and expenses arising out of your use of the service or violation of these terms.
                </p>
              </section>

              <section>
                <h3 className="text-xl font-semibold text-gray-900 mb-3">9. Termination</h3>
                <p className="leading-relaxed">
                  We may terminate or suspend your account and access to the service immediately, without prior notice, for conduct that we believe violates these terms or is harmful to other users, us, or third parties.
                </p>
              </section>

              <section>
                <h3 className="text-xl font-semibold text-gray-900 mb-3">10. Changes to Terms</h3>
                <p className="leading-relaxed">
                  We reserve the right to modify these terms at any time. We will notify users of any material changes. Your continued use of the service after changes constitutes acceptance of the new terms.
                </p>
              </section>

              <section>
                <h3 className="text-xl font-semibold text-gray-900 mb-3">11. Governing Law</h3>
                <p className="leading-relaxed">
                  These terms shall be governed by and construed in accordance with applicable laws, without regard to conflict of law provisions.
                </p>
              </section>

              <section>
                <h3 className="text-xl font-semibold text-gray-900 mb-3">12. Contact Information</h3>
                <p className="leading-relaxed">
                  If you have any questions about these terms, please contact us at{' '}
                  <a href="mailto:legal@vianexta.com" className="text-[#09543D] hover:underline">legal@vianexta.com</a>
                </p>
              </section>
            </div>

            {/* Back to Home */}
            <div className="mt-12 text-center">
              <Link 
                to="/" 
                className="text-[#09543D] font-semibold hover:underline text-sm md:text-base"
              >
                ← Back to home
              </Link>
            </div>
          </div>
        </div>
      </div>

      {/* Chat Button */}
      <ChatButton />
    </div>
  )
}

export default TermsOfService







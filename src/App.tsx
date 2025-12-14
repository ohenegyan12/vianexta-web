import { useState } from 'react'
import { Routes, Route } from 'react-router-dom'
import Header from './components/Header'
import Hero from './components/Hero'
import FromIdeaToInventory from './components/FromIdeaToInventory'
import ChainBuilder from './components/ChainBuilder'
import MeetClareAndForman from './components/MeetClareAndForman'
import ExperienceClare from './components/ExperienceClare'
import TrustedBrands from './components/TrustedBrands'
import HearFromCustomers from './components/HearFromCustomers'
import FAQ from './components/FAQ'
import Footer from './components/Footer'
import ChatButton from './components/ChatButton'
import SignIn from './components/SignIn'
import ForgotPassword from './components/ForgotPassword'
import SignUp from './components/SignUp'
import BuyerWizard from './components/BuyerWizard'
import BuyerDashboard from './components/BuyerDashboard'
import BuyerAccount from './components/BuyerAccount'
import BuyerOrders from './components/BuyerOrders'
import BuyerCart from './components/BuyerCart'
import BuyerHelp from './components/BuyerHelp'
import Checkout from './components/Checkout'
import Contact from './components/Contact'
import Careers from './components/Careers'
import PrivacyPolicy from './components/PrivacyPolicy'
import TermsOfService from './components/TermsOfService'
import Recommend from './components/Recommend'

function Home() {
  const [isBuyMode, setIsBuyMode] = useState(false)

  return (
    <>
      <Header isBuyMode={isBuyMode} />
      <Hero 
        onBuyClick={() => setIsBuyMode(true)} 
        onBuildClick={() => setIsBuyMode(false)} 
      />
      <FromIdeaToInventory isBuyMode={isBuyMode} />
      <ChainBuilder isBuyMode={isBuyMode} />
      <MeetClareAndForman isBuyMode={isBuyMode} />
      <ExperienceClare isBuyMode={isBuyMode} />
      <TrustedBrands />
      <HearFromCustomers />
      <FAQ />
      <Footer />
      <ChatButton isBuyMode={isBuyMode} />
    </>
  )
}

function App() {
  return (
    <div className="min-h-screen bg-[#F9F7F1] overflow-x-hidden">
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/signin" element={<SignIn />} />
        <Route path="/forgot-password" element={<ForgotPassword />} />
        <Route path="/signup" element={<SignUp />} />
        <Route path="/buyer" element={<BuyerWizard />} />
        <Route path="/buyer/dashboard" element={<BuyerDashboard />} />
        <Route path="/buyer/account" element={<BuyerAccount />} />
        <Route path="/buyer/orders" element={<BuyerOrders />} />
        <Route path="/buyer/cart" element={<BuyerCart />} />
        <Route path="/buyer/help" element={<BuyerHelp />} />
        <Route path="/checkout" element={<Checkout />} />
        <Route path="/contact" element={<Contact />} />
        <Route path="/careers" element={<Careers />} />
        <Route path="/privacy" element={<PrivacyPolicy />} />
        <Route path="/terms" element={<TermsOfService />} />
        <Route path="/recommend" element={<Recommend />} />
      </Routes>
    </div>
  )
}

export default App


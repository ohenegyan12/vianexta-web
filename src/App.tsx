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
import Checkout from './components/Checkout'

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
      <ChatButton />
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
        <Route path="/checkout" element={<Checkout />} />
      </Routes>
    </div>
  )
}

export default App


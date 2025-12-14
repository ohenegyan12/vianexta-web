import { Link } from 'react-router-dom'

interface BuyerTopNavProps {
  userName?: string
  userAvatar?: string
  onSidebarToggle: () => void
}

function BuyerTopNav({ userName = 'User', userAvatar, onSidebarToggle }: BuyerTopNavProps) {
  return (
    <nav className="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-40">
      <div className="flex items-center justify-between px-4 py-3">
        <button
          type="button"
          onClick={onSidebarToggle}
          className="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-2 rounded transition-colors"
          aria-label="Toggle sidebar"
        >
          <i className="fa fa-align-left"></i>
        </button>
        <h1 className="text-xl font-bold" style={{ color: '#07382F' }}>
          Hi {userName}!
        </h1>
        <Link to="/buyer" className="flex items-center">
          {userAvatar ? (
            <img
              src={userAvatar}
              alt="User"
              className="h-10 w-10 rounded-full object-cover"
            />
          ) : (
            <div className="h-10 w-10 rounded-full bg-[#07382F] flex items-center justify-center text-white font-semibold">
              {userName.charAt(0).toUpperCase()}
            </div>
          )}
        </Link>
      </div>
    </nav>
  )
}

export default BuyerTopNav



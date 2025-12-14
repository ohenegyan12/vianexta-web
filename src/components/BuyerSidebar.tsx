import { Link, useLocation, useNavigate } from 'react-router-dom'
import vianextaLogo from '../../assets/vianexta-logo.svg'

interface BuyerSidebarProps {
  isCollapsed: boolean
  onToggle?: () => void
  userType?: string
}

function BuyerSidebar({ isCollapsed, userType = 'Buyer' }: BuyerSidebarProps) {
  const location = useLocation()
  const navigate = useNavigate()

  const handleLogout = () => {
    localStorage.removeItem('authToken')
    localStorage.removeItem('user')
    navigate('/signin')
  }

  const isActive = (path: string) => {
    return location.pathname === path
  }

  return (
    <nav
      id="sidebar"
      className={`fixed left-0 top-0 h-full bg-[#07382F] text-white transition-all duration-300 z-50 ${
        isCollapsed ? 'w-24' : 'w-64'
      }`}
      style={{ boxShadow: 'rgba(0, 0, 0, 0.24) 0px 3px 8px' }}
    >
      <div className="sidebar-header p-5 bg-[#07382F]">
        {!isCollapsed && (
          <Link to="/" className="flex items-center mb-4">
            <img src={vianextaLogo} alt="ViaNexta" className="h-10 w-auto" />
          </Link>
        )}
        {!isCollapsed && (
          <strong className="text-sm font-semibold block mt-2">Account : {userType}</strong>
        )}
      </div>

      <ul className="list-unstyled components p-0 m-0" style={{ padding: '20px 0' }}>
        <li className={isActive('/buyer/dashboard') ? 'active' : ''}>
          <Link
            to="/buyer/dashboard"
            className={`block px-4 py-3 text-white hover:bg-white hover:text-[#07382F] transition-colors ${
              isActive('/buyer/dashboard') ? 'bg-white text-[#07382F]' : ''
            } ${isCollapsed ? 'text-center' : ''}`}
            style={{ fontSize: '1.1em' }}
          >
            <i className={`fa fa-home ${isCollapsed ? '' : 'mr-3'}`} style={isCollapsed ? { display: 'block', fontSize: '1.8em', marginBottom: '5px' } : {}}></i>
            {!isCollapsed && <span>Dashboard</span>}
          </Link>
        </li>
        <li className={isActive('/buyer/account') ? 'active' : ''}>
          <Link
            to="/buyer/account"
            className={`block px-4 py-3 text-white hover:bg-white hover:text-[#07382F] transition-colors ${
              isActive('/buyer/account') ? 'bg-white text-[#07382F]' : ''
            } ${isCollapsed ? 'text-center' : ''}`}
            style={{ fontSize: '1.1em' }}
          >
            <i className={`fa fa-briefcase ${isCollapsed ? '' : 'mr-3'}`} style={isCollapsed ? { display: 'block', fontSize: '1.8em', marginBottom: '5px' } : {}}></i>
            {!isCollapsed && <span>Account</span>}
          </Link>
        </li>
        <li>
          <Link
            to="/buyer"
            className={`block px-4 py-3 text-white hover:bg-white hover:text-[#07382F] transition-colors ${
              isActive('/buyer') && !isActive('/buyer/dashboard') && !isActive('/buyer/account') && !isActive('/buyer/orders') && !isActive('/buyer/cart') && !isActive('/buyer/help') ? 'bg-white text-[#07382F]' : ''
            } ${isCollapsed ? 'text-center' : ''}`}
            style={{ fontSize: '1.1em' }}
          >
            <i className={`fa fa-shopping-bag ${isCollapsed ? '' : 'mr-3'}`} style={isCollapsed ? { display: 'block', fontSize: '1.8em', marginBottom: '5px' } : {}}></i>
            {!isCollapsed && <span>Marketplace</span>}
          </Link>
        </li>
        <li className={isActive('/buyer/orders') ? 'active' : ''}>
          <Link
            to="/buyer/orders"
            className={`block px-4 py-3 text-white hover:bg-white hover:text-[#07382F] transition-colors ${
              isActive('/buyer/orders') ? 'bg-white text-[#07382F]' : ''
            } ${isCollapsed ? 'text-center' : ''}`}
            style={{ fontSize: '1.1em' }}
          >
            <i className={`fa fa-list ${isCollapsed ? '' : 'mr-3'}`} style={isCollapsed ? { display: 'block', fontSize: '1.8em', marginBottom: '5px' } : {}}></i>
            {!isCollapsed && <span>Orders</span>}
          </Link>
        </li>
        <li className={isActive('/buyer/cart') ? 'active' : ''}>
          <Link
            to="/buyer/cart"
            className={`block px-4 py-3 text-white hover:bg-white hover:text-[#07382F] transition-colors ${
              isActive('/buyer/cart') ? 'bg-white text-[#07382F]' : ''
            } ${isCollapsed ? 'text-center' : ''}`}
            style={{ fontSize: '1.1em' }}
          >
            <i className={`fa fa-shopping-cart ${isCollapsed ? '' : 'mr-3'}`} style={isCollapsed ? { display: 'block', fontSize: '1.8em', marginBottom: '5px' } : {}}></i>
            {!isCollapsed && <span>Cart</span>}
          </Link>
        </li>
        <li className={isActive('/buyer/help') ? 'active' : ''}>
          <Link
            to="/buyer/help"
            className={`block px-4 py-3 text-white hover:bg-white hover:text-[#07382F] transition-colors ${
              isActive('/buyer/help') ? 'bg-white text-[#07382F]' : ''
            } ${isCollapsed ? 'text-center' : ''}`}
            style={{ fontSize: '1.1em' }}
          >
            <i className={`fa fa-info ${isCollapsed ? '' : 'mr-3'}`} style={isCollapsed ? { display: 'block', fontSize: '1.8em', marginBottom: '5px' } : {}}></i>
            {!isCollapsed && <span>Help</span>}
          </Link>
        </li>
        <li>
          <button
            onClick={handleLogout}
            className={`w-full text-left px-4 py-3 text-white hover:bg-white hover:text-[#07382F] transition-colors ${
              isCollapsed ? 'text-center' : ''
            }`}
            style={{ fontSize: '1.1em' }}
          >
            <i className={`fa fa-sign-out ${isCollapsed ? '' : 'mr-3'}`} style={isCollapsed ? { display: 'block', fontSize: '1.8em', marginBottom: '5px' } : {}}></i>
            {!isCollapsed && <span>Logout</span>}
          </button>
        </li>
      </ul>
    </nav>
  )
}

export default BuyerSidebar


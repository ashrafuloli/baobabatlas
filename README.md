BAOBAB ATLAS
│
├── 🌐 PUBLIC WEBSITE
│   │
│   ├── Home
│   ├── Shop
│   ├── Product Details
│   ├── Categories
│   ├── Smart Buy
│   ├── About
│   ├── Contact
│   ├── Login
│   └── Register
│
│
├── 👤 CUSTOMER / CLIENT PORTAL
│   │
│   ├── Dashboard
│   │
│   ├── 🛒 ECOMMERCE
│   │   │
│   │   ├── Shop
│   │   ├── Product Details
│   │   ├── Cart
│   │   ├── Checkout
│   │   ├── Payment
│   │   ├── Payment Success
│   │   ├── Payment Failed
│   │   │
│   │   ├── My Orders
│   │   ├── Order Details
│   │   │
│   │   └── Ecommerce Shipment
│   │       ├── Shipment Details
│   │       ├── Tracking Number
│   │       ├── Shipment Status
│   │       └── Delivery Status
│   │
│   │
│   ├── 🌎 SMART BUY
│   │   │
│   │   ├── My Smart Buy Requests
│   │   ├── Start Smart Buy
│   │   ├── Request Confirmation
│   │   ├── Request Details
│   │   ├── Quote
│   │   ├── Payment
│   │   ├── Payment Success
│   │   ├── Payment Failed
│   │   │
│   │   └── Smart Buy Shipment
│   │       ├── Shipment Details
│   │       ├── Tracking Number
│   │       ├── Shipment Status
│   │       └── Delivery Status
│   │
│   │
│   ├── 👤 ACCOUNT
│   │   │
│   │   ├── Profile
│   │   ├── My Orders
│   │   ├── My Smart Buy Requests
│   │   ├── Payments
│   │   └── Notifications
│   │
│   └── Logout
│
│
└── ⚙️ ADMIN PANEL
│
├── Dashboard
│
├── 👥 USER MANAGEMENT
│   │
│   ├── Users
│   ├── Roles
│   └── Permissions
│
│
├── 🛒 ECOMMERCE MANAGEMENT
│   │
│   ├── Products
│   ├── Categories
│   ├── Orders
│   ├── Order Details
│   ├── Payments
│   │
│   └── Ecommerce Shipments
│       ├── Shipment List
│       ├── Shipment Details
│       ├── Create Shipment
│       ├── Tracking Number
│       ├── Carrier
│       ├── Shipment Status
│       └── Delivery Status
│
│
├── 🌎 SMART BUY MANAGEMENT
│   │
│   ├── Smart Buy Requests
│   ├── Request Details
│   ├── Edit Request
│   ├── Quote
│   ├── Purchase
│   ├── Payments
│   │
│   └── Smart Buy Shipments
│       ├── Shipment List
│       ├── Shipment Details
│       ├── Create Shipment
│       ├── Tracking Number
│       ├── Carrier
│       ├── Shipment Status
│       └── Delivery Status
│
│
├── 💳 PAYMENTS
│   │
│   ├── Ecommerce Payments
│   └── Smart Buy Payments
│
│
├── 📊 REPORTS
│   │
│   ├── Ecommerce Reports
│   ├── Smart Buy Reports
│   ├── Sales Reports
│   ├── Payment Reports
│   └── Shipment Reports
│
│
├── 🔔 NOTIFICATIONS
│
│
└── ⚙️ SETTINGS
│   │
│   ├── General Settings
│   ├── Company Profile
│   ├── Notifications
│   ├── Roles & Permissions
│   ├── Security
│   └── Audit Logs





smart buy flow
========================


CUSTOMER
│
▼
My Smart Buy
/portal/my-smart-buy
│
├── Create Request
│      /portal/my-smart-buy/create
│
▼
REQUEST SUBMITTED
│
│ Admin reviews
▼
ADMIN
/portal/smart-buy
│
▼
Request Details
/portal/smart-buy/{smartBuy}
│
▼
Prepare Quote
/portal/smart-buy/{smartBuy}/quote
│
│ Quote sent to customer
▼
CUSTOMER
/portal/my-smart-buy/{smartBuy}/quote
│
▼
Accept Quote
│
▼
Payment
/portal/my-smart-buy/{smartBuy}/payment
│
├── Failed
│     /payment/failed
│
└── Success
/payment/success
│
▼
ADMIN
Purchase Product
/portal/smart-buy/{smartBuy}/purchase
│
▼
Product Purchased
│
▼
Shipment
/portal/smart-buy/{smartBuy}/shipment
│
▼
IN TRANSIT
│
▼
CUSTOMER TRACKING
/portal/my-smart-buy/{smartBuy}/tracking
│
▼
ARRIVED
│
▼
COMPLETED






SMART BUY

01. Existing Structure Analysis
    ↓
02. Database Architecture
    ↓
03. Migrations
    ↓
04. Models + Relationships
    ↓
05. Client Request Creation
    ↓
06. Client Request List + Details
    ↓
07. Admin Request Management
    ↓
08. Quote System
    ↓
09. Client Quote Accept / Reject
    ↓
10. Payment Architecture
    ↓
11. Shipment
    ↓
12. Tracking
    ↓
13. Status Workflow + Validation
    ↓
14. Testing

────────────────────────

ECOMMERCE

01. Database Architecture
    ↓
02. Categories
    ↓
03. Products
    ↓
04. Product Images
    ↓
05. Product Listing
    ↓
06. Product Details
    ↓
07. Cart
    ↓
08. Checkout
    ↓
09. Orders
    ↓
10. Payment
    ↓
11. Shipment
    ↓
12. Tracking
    ↓
13. Reports

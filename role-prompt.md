You are a senior Laravel architect and full-stack developer.

I am building a Laravel-based portal with Admin and Client roles. The authentication and foundation of the project are already completed. Before writing or modifying any code, you must understand the existing project structure and continue development without breaking the current system.

==================================================
PROJECT OVERVIEW
==================================================

The project already includes:

- Login system
- Registration system
- Authentication
- Profile Settings
- User Management
- Role Management
- Permission Management
- Admin and Client roles
- Role-based sidebar navigation
- Permission-based routes
- Admin dashboard
- Client portal/dashboard
- Static UI pages for Ecommerce
- Static UI pages for Smart Buy
- Payments pages
- Reports pages
- Settings pages
- Audit Logs

The existing UI, routes, permissions, layouts, naming conventions, and project structure should be respected.

Do not unnecessarily redesign or restructure existing completed modules.

==================================================
CURRENT DEVELOPMENT GOAL
==================================================

I now want to make the application dynamic.

Development must happen in this order:

PHASE 1 → SMART BUY
PHASE 2 → ECOMMERCE

Do NOT start Ecommerce development until the required Smart Buy core workflow is completed.

We will work module by module and step by step.

Do not try to build the entire application in one response.

==================================================
IMPORTANT DEVELOPMENT RULES
==================================================

Before starting a new module:

1. Understand the existing route structure.
2. Understand existing Models and database migrations.
3. Understand existing Roles and Permissions.
4. Reuse existing layouts and Blade structure.
5. Reuse existing UI pages whenever possible.
6. Do not create duplicate routes or duplicate functionality.
7. Do not change completed authentication, profile, user management, or role management unless absolutely necessary.
8. Follow Laravel best practices.
9. Keep the architecture scalable and clean.
10. Use proper Eloquent relationships.
11. Use Form Requests for validation when appropriate.
12. Use database transactions for critical multi-step operations.
13. Avoid unnecessary packages.
14. Do not hardcode business data that should come from the database.
15. Follow the existing project naming conventions.

Before implementing each major step, explain:

- What we are building
- Why it is needed
- Which database tables are required
- Which models are required
- Which relationships are required
- Which routes will be added
- Which permissions are required
- Which files will be created or modified

Then implement the feature.

==================================================
PHASE 1 — SMART BUY
==================================================

Smart Buy is the first dynamic module.

The general workflow should be:

CLIENT
↓
Create Smart Buy Request
↓
Add one or multiple requested items
↓
Submit Request
↓
ADMIN REVIEWS REQUEST
↓
Admin updates/reviews request
↓
Admin creates a Quote
↓
CLIENT REVIEWS QUOTE
↓
Client accepts or rejects the quote
↓
If accepted:
↓
Payment Process
↓
Payment Record Created
↓
Smart Buy Request Processing
↓
Shipment Created
↓
Tracking Updates Added
↓
Client can track progress
↓
Delivered / Completed

==================================================
SMART BUY DEVELOPMENT ORDER
==================================================

Work through the Smart Buy module in this exact order unless the existing project architecture requires a small adjustment.

STEP 1
Smart Buy database architecture and workflow planning.

Define the required tables and relationships before writing migrations.

Potential entities may include:

- Smart Buy Requests
- Smart Buy Items
- Smart Buy Quotes
- Smart Buy Quote Items
- Payments
- Shipments
- Tracking Updates

However, first inspect the existing project structure and determine whether any existing tables such as payments, shipments, or tracking should be reused.

Do not create duplicate tables if equivalent functionality already exists.

--------------------------------------------------

STEP 2
Create Smart Buy migrations and models.

Use proper foreign keys, indexes, statuses, and relationships.

Suggested relationship structure:

User
└── hasMany SmartBuyRequests

SmartBuyRequest
├── belongsTo User
├── hasMany SmartBuyItems
├── hasMany / hasOne Quotes depending on business workflow
├── may have Payment
└── may have Shipment

SmartBuyQuote
└── hasMany SmartBuyQuoteItems

Do not blindly follow this structure if the existing database architecture suggests a better solution.

--------------------------------------------------

STEP 3
Client Smart Buy Request Creation.

The client should be able to:

- View Smart Buy requests
- Create a new request
- Add multiple items
- Add product/request information
- Submit the request
- View request details
- View current status

Use existing permissions where available.

If a required permission does not exist, clearly identify it before adding it.

--------------------------------------------------

STEP 4
Admin Smart Buy Management.

Admin should be able to:

- View all Smart Buy requests
- Filter requests by status
- View request details
- Review submitted items
- Update request status
- Prepare a quote

--------------------------------------------------

STEP 5
Smart Buy Quote System.

Admin should be able to create a quote containing:

- Quote items
- Quantity
- Unit price
- Additional costs if needed
- Shipping cost if needed
- Total amount
- Quote validity date
- Notes

The client should be able to:

- View the quote
- Accept the quote
- Reject the quote

Important:

Quote acceptance must safely update the Smart Buy request status.

Rejected quotes should not accidentally create payments or shipments.

Use database transactions where multiple records are updated together.

--------------------------------------------------

STEP 6
Smart Buy Payment Integration Architecture.

First implement the internal payment workflow and database structure.

The workflow should support:

- Pending
- Paid
- Failed
- Refunded if required by the existing project architecture

A Smart Buy payment must be connected to the appropriate Smart Buy request or quote.

If a general Payment model/table already exists, reuse it instead of creating a duplicate Smart Buy payment system.

--------------------------------------------------

STEP 7
Smart Buy Shipment.

After the required payment/business condition is satisfied:

Admin should be able to:

- Create shipment
- Assign carrier
- Add tracking number
- Update shipment status
- Add shipment/tracking updates

Client should be able to:

- View shipment
- View tracking number
- View tracking history
- View current shipment status

--------------------------------------------------

STEP 8
Smart Buy Status Workflow.

Use a clear and controlled workflow.

For example:

draft
submitted
under_review
quoted
awaiting_payment
paid
processing
shipped
delivered
completed
cancelled
rejected

Do not allow invalid status transitions.

Create a clear strategy for handling status changes.

==================================================
PHASE 2 — ECOMMERCE
==================================================

Only start this phase after the core Smart Buy workflow is completed and tested.

The Ecommerce workflow should be:

ADMIN
↓
Create Categories
↓
Create Products
↓
Add Product Images
↓
Manage Price and Stock
↓
Publish Product

CLIENT
↓
Browse Products
↓
View Product Details
↓
Add Product to Cart
↓
Manage Cart
↓
Checkout
↓
Create Order
↓
Payment
↓
Order Processing
↓
Shipment
↓
Tracking
↓
Delivered

==================================================
ECOMMERCE DEVELOPMENT ORDER
==================================================

STEP 1
Review the existing database and architecture.

Plan:

- Categories
- Products
- Product Images
- Inventory / Stock
- Cart
- Cart Items
- Orders
- Order Items

Reuse existing:

- Users
- Payments
- Shipments
- Tracking

when appropriate.

--------------------------------------------------

STEP 2
Category Management.

Admin CRUD:

- List
- Create
- Edit
- Delete
- Status management

--------------------------------------------------

STEP 3
Product Management.

Admin should be able to manage:

- Category
- Product name
- Slug
- SKU
- Description
- Price
- Sale price if needed
- Stock quantity
- Product status
- Product images

--------------------------------------------------

STEP 4
Client Product Browsing.

Client should be able to:

- Browse products
- Search products
- Filter products if the current UI supports it
- View product details

--------------------------------------------------

STEP 5
Cart System.

The client should be able to:

- Add products to cart
- Update quantity
- Remove products
- View subtotal
- View totals

Validate stock availability.

--------------------------------------------------

STEP 6
Checkout and Order Creation.

The workflow should safely:

1. Validate cart
2. Validate stock
3. Create order
4. Create order items
5. Calculate totals
6. Create/update payment record
7. Update stock
8. Clear the cart when appropriate

Use a database transaction.

--------------------------------------------------

STEP 7
Ecommerce Payment.

Reuse the central payment architecture created or used during Smart Buy development.

Payments should be able to distinguish between:

- Ecommerce payments
- Smart Buy payments

Do not create two unrelated payment systems.

--------------------------------------------------

STEP 8
Order Management.

Admin should be able to:

- View orders
- View order details
- Update order status
- Manage order items where appropriate
- View payment status
- Create shipment

--------------------------------------------------

STEP 9
Shipment and Tracking.

Reuse the central shipment/tracking system where possible.

The client should be able to track Ecommerce orders.

==================================================
SHARED SYSTEM ARCHITECTURE
==================================================

The following systems should preferably be reusable across Smart Buy and Ecommerce when architecturally appropriate:

- Payments
- Shipments
- Tracking
- Notifications
- Audit Logs

For example, the system may need to identify whether a payment belongs to:

- Ecommerce
- Smart Buy

The same principle can apply to shipments and tracking.

Before deciding the database structure, carefully evaluate the cleanest scalable architecture.

Do not over-engineer.

==================================================
REPORTS
==================================================

Reports should be developed after the core Smart Buy and Ecommerce workflows are working.

Reports may include separate sections for:

- Ecommerce
- Smart Buy

Reports should be generated from actual database data.

Do not implement fake/static report data as the final solution.

==================================================
AUDIT LOGS
==================================================

Important business actions should be prepared for audit logging, especially:

- Smart Buy request creation
- Smart Buy status changes
- Quote creation
- Quote acceptance/rejection
- Payment status changes
- Shipment updates
- Order status changes
- Important admin actions

Use the existing Audit Logs architecture if one already exists.

==================================================
HOW WE WILL WORK TOGETHER
==================================================

We will work one step at a time.

For every step:

1. First analyze the existing relevant project structure.
2. Explain the implementation plan.
3. Identify files that need to be created or updated.
4. Implement only the current step.
5. Provide complete code for modified files when requested.
6. Wait until that step is complete before moving to the next major step.

Do not jump ahead.

Do not create unnecessary features.

Do not redesign existing completed pages unless required for dynamic functionality.

==================================================
CURRENT TASK
==================================================

We are starting with:

PHASE 1 — SMART BUY
STEP 1 — DATABASE ARCHITECTURE AND WORKFLOW PLANNING

First, analyze the existing Smart Buy-related routes, pages, models, migrations, permissions, payments, shipments, and tracking structure.

Then provide a clear Smart Buy database architecture and relationship plan.

Do NOT create migrations or write implementation code yet.

First provide:

1. Existing structure analysis
2. Recommended tables
3. Important fields for each table
4. Model relationships
5. Status workflow
6. Reusable systems
7. Files that will eventually need to be created or updated
8. Step-by-step implementation plan

Wait for approval before proceeding to migrations.

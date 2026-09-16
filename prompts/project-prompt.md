I am continuing an existing logistics/shipping management dashboard project.
Read and understand everything below before doing anything.

IMPORTANT:
Do not redesign the project from scratch.
Do not change the established UI system, typography system, SCSS structure, naming conventions, or workflow unless I explicitly ask you to.

I want to continue development from where I stopped.

==================================================
1. PROJECT OVERVIEW
   ==================================================

This is a logistics/shipping management platform called:

Baobab Atlas

The platform will manage logistics services and shipment requests.

Current services:

1. Freight Forwarding
2. Customs Clearance

Future services:

3. Warehousing
4. Distribution

The system will eventually allow clients/users to:

- Create a product/shipment request
- Enter product name
- Enter quantity
- Provide origin/location
- Provide destination/location
- Select a logistics service
- Submit the request
- Make payment
- Receive a tracking/request ID
- Track the request/shipment
- View the complete shipment timeline
- See status updates
- See when the shipment is delivered/completed

Admin will manage everything from the dashboard.

==================================================
2. CORE BUSINESS WORKFLOW
   ==================================================

The main workflow is:

Client
↓
Create Request
↓
Select Product
↓
Select Service
↓
Enter Origin / Destination
↓
Submit Request
↓
Payment
↓
Admin Reviews Request
↓
Request Approved
↓
Shipment Created
↓
Shipment Processing
↓
Shipment In Transit
↓
Customs Clearance if required
↓
Out for Delivery
↓
Delivered
↓
Request/Shipment Completed

Client should be able to see the complete timeline from their dashboard.

Admin should be able to update shipment/request statuses.

The system should be designed so more services can be added later without rebuilding the whole dashboard.

==================================================
3. SERVICES
   ==================================================

Current services:

Freight Forwarding
Customs Clearance

Future:

Warehousing
Distribution

Use these exact names in the UI.

Preferred icons already used:

Freight Forwarding:
ri-ship-line / ri-truck-line

Customs Clearance:
ri-file-shield-2-line

Warehousing:
ri-home-gear-line

Distribution:
ri-route-line

Services should eventually be manageable dynamically from:

Services
├── All Services
├── Add Service
└── Service Details

==================================================
4. ADMIN DASHBOARD STRUCTURE
   ==================================================

The planned dashboard structure is:

Dashboard

Requests
├── All Requests
├── Create Request
├── Pending
├── Awaiting Payment
├── Under Review
└── Request Details

Shipments
├── All Shipments
├── Active
├── In Transit
├── Delivered
└── Shipment Details

Tracking

Services
├── All Services
├── Add Service
└── Service Details

Payments

Invoices

Clients

Locations

Reports

Profile

Settings

The sidebar has already been designed around these sections.

==================================================
5. SIDEBAR STRUCTURE
   ==================================================

Sidebar groups:

MAIN

Dashboard
Requests
Shipments
Tracking

OPERATIONS

Freight Forwarding
Customs Clearance
Warehousing
Distribution
Services

FINANCE

Payments
Invoices

MANAGEMENT

Clients
Locations
Reports

SYSTEM

Profile
Settings

Logout

Existing sidebar uses Remix Icons.

Examples:

Dashboard:
ri-dashboard-line

Requests:
ri-file-list-3-line

Shipments:
ri-box-3-line

Tracking:
ri-map-pin-time-line

Freight Forwarding:
ri-truck-line / ri-ship-line

Customs Clearance:
ri-file-shield-2-line

Warehousing:
ri-home-gear-line

Distribution:
ri-route-line

Services:
ri-service-line

Payments:
ri-bank-card-line

Invoices:
ri-bill-line

Clients:
ri-user-3-line

Locations:
ri-map-2-line

Reports:
ri-bar-chart-2-line

Profile:
ri-user-settings-line

Settings:
ri-settings-3-line

Logout:
ri-logout-box-r-line

The sidebar also supports submenu/dropdown behavior.

Existing jQuery submenu logic concept:

$('.has-submenu > a').on('click', function(){
$(this).children('.submenu').slideToggle();
});

When creating submenu HTML, use proper `.has-submenu` and `.submenu` structure.

==================================================
6. TECHNOLOGY / FILE STYLE
   ==================================================

This is a Laravel Blade project.

HTML should be written as Blade-compatible HTML.

Examples:

{{ route('dashboard') }}

{{ route('profile') }}

{{ route('settings') }}

{{ asset('logo.png') }}

Use @csrf inside POST forms.

Frontend:

HTML
SCSS
jQuery
DataTables

DataTables library:

DataTables - The Javascript Table Solution

https://datatables.net/

The Requests listing uses DataTables.

Do not replace DataTables with another table library unless explicitly requested.

==================================================
7. SCSS VARIABLES
   ==================================================

These are the project's established SCSS variables.

DO NOT create a new color system.

Use these variables:

$body-fonts: "Poppins", sans-serif;
$header-fonts: "Poppins", sans-serif;
$icon-font: "Font Awesome 6 Pro";

$body-fz: 16px;
$head-fw: 700;

$light: #F2F4F7;
$dark: #101a23;
$gray: #ddd;
$heading-color: #0D2B5A;
$body-color: #555555;
$theme-color: #177245;
$theme-color-2: #D4AF37;
$hr-color: #352323;

$success: #198754;
$info: #0dcaf0;
$warning: #ffc107;
$danger: #dc3545;

There is already a responsive mixin:

@mixin mq($value) {

@if $value=='xxl' {
@media (min-width: 1400px) and (max-width: 1700px) {
@content;
}
}

@if $value=='xl' {
@media (min-width: 1200px) and (max-width: 1399px) {
@content;
}
}

@if $value=='lg' {
@media (min-width: 992px) and (max-width: 1199px) {
@content;
}
}

@if $value=='md' {
@media (min-width: 768px) and (max-width: 991px) {
@content;
}
}

@if $value=='xs' {
@media (max-width: 767px) {
@content;
}
}

@if $value=='sm' {
@media (min-width: 480px) and (max-width: 767px) {
@content;
}
}
}

There is also:

@function argb($color, $opacity: 0.3) {
@return rgba($color, $opacity);
}

Use these instead of creating separate media-query systems.

==================================================
8. VERY IMPORTANT TYPOGRAPHY SYSTEM
   ==================================================

I updated the Requests page typography and this is now the MASTER typography reference.

When creating new dashboard pages, follow this typography scale.

Desktop reference:

Page H1:
30px

Page subtitle:
11px

Page description:
13px

Card heading:
20px

Card description:
14px

Table heading:
14px

Table body:
11px

Request ID:
14px

Client name:
14px

Client location:
12px

Product:
14px

Service:
14px

Route:
14px

Amount:
14px

Status badge:
12px

Date:
14px

DataTables controls:
14px

Pagination:
14px

Use responsive reductions with:
xl
lg
md
xs

Do NOT make new dashboard pages excessively tiny.

The previous version used too many 8px / 9px / 10px fonts.
That is NOT the preferred system anymore.

The updated Requests page typography is the source of truth.

==================================================
9. RESPONSIVE DESIGN RULE
   ==================================================

Responsiveness is very important.

Use:

@include mq(xl)
@include mq(lg)
@include mq(md)
@include mq(xs)

Do not write generic media queries unless necessary.

Desktop should be spacious and readable.

Tablet should reduce gaps, padding and font sizes gradually.

Mobile should stack columns.

Examples:

Desktop:
grid-template-columns: repeat(2, 1fr);

Mobile:
grid-template-columns: 1fr;

For three-column forms:

Desktop:
grid-template-columns: repeat(3, 1fr);

Tablet:
grid-template-columns: repeat(2, 1fr);

Mobile:
grid-template-columns: 1fr;

Do not simply use:
width: 100%;
for everything.

Keep the UI professional and balanced.

==================================================
10. UI DESIGN LANGUAGE
    ==================================================

The dashboard design should be:

- Modern
- Professional
- Clean
- Premium
- Minimal
- Logistics-focused
- Corporate
- Easy to scan
- Desktop-first but fully responsive

Main visual style:

White cards
Soft borders
Very subtle shadows
Rounded corners
Green primary actions
Dark navy headings
Gray secondary text
Light gray dashboard background

Primary:
$theme-color

Heading:
$heading-color

Body:
$body-color

Background:
$light

Success:
$success

Warning:
$warning

Danger:
$danger

Info:
$info

Avoid excessive gradients.

Avoid unnecessary animations.

Use subtle hover transitions.

==================================================
11. CURRENT FOLDER / FILE APPROACH
    ==================================================

The project is being organized page-by-page.

Dashboard pages are being separated into logical folders.

The Requests section should contain:

requests/
├── index.blade.php
├── create.blade.php
├── pending.blade.php
├── awaiting-payment.blade.php
├── under-review.blade.php
└── details.blade.php

SCSS should follow the corresponding page/component organization already established in the project.

Do not randomly create unrelated folders.

Keep naming consistent.

==================================================
12. COMPLETED WORK
    ==================================================

The following work has already been done:

1. Dashboard basic structure
2. Dashboard sidebar
3. Sidebar navigation groups
4. Sidebar submenu concept
5. Requests page folder/file planning
6. Requests → All Requests UI
7. DataTables integration planning
8. Requests demo data table
9. Requests statistics cards
10. Requests table responsive styling
11. Requests DataTables controls styling
12. Requests typography was updated
13. Requests → Request Details UI
14. Requests → Create Request UI

The current project is therefore already beyond the initial dashboard setup.

==================================================
13. REQUESTS → ALL REQUESTS
    ==================================================

The All Requests page contains:

Page title:
All Requests

Description:
Manage and review all service requests.

Statistics:

Total Requests
Pending
Awaiting Payment
Under Review

DataTable columns:

Request ID
Client
Product
Service
Origin
Destination
Amount
Status
Date
Action

Example statuses:

Pending
Awaiting Payment
Under Review
Approved
Rejected
Completed

The table uses DataTables.

Each request has an action/view button that leads to Request Details.

==================================================
14. REQUESTS → REQUEST DETAILS
    ==================================================

Request Details page has already been designed.

Structure:

Request #REQ-10256
Status

Client Information

Product Information

Service & Route

Payment Information

Request Notes

Request Summary

Request Timeline

Request Actions

The timeline shows:

Request Submitted
↓
Payment Confirmed
↓
Under Review
↓
Request Approved
↓
Shipment Created

Admin actions include:

Reject Request
Approve Request

After approval, the request should eventually allow:

Create Shipment

==================================================
15. REQUESTS → CREATE REQUEST
    ==================================================

This page has already been designed.

Main sections:

01 Client Information

02 Product Information

03 Service Selection

04 Shipment Route

05 Pricing

06 Additional Notes

Client Information:

Select Client
Client preview

Product:

Product Name
Category
Quantity
Unit
Product Value
Product Reference
Product Description

Services:

Freight Forwarding
Customs Clearance
Warehousing
Distribution

Route:

Origin
Destination

Pricing:

Service Charge
Additional Charges
Discount
Total Request Amount

Additional Notes:

Internal notes

Actions:

Cancel
Create Request

The service selection uses radio buttons.

==================================================
16. IMPORTANT DIFFERENCE: ADMIN VS CLIENT
    ==================================================

There are two different request creation contexts.

ADMIN:

Select Client
Product
Service
Origin
Destination
Pricing
Internal Notes
Create Request

CLIENT:

Product
Quantity
Location
Service
Request
Payment

Do not assume both forms should be identical.

The client workflow will be developed later.

==================================================
17. REQUEST STATUS WORKFLOW
    ==================================================

Initial request statuses:

Pending
Awaiting Payment
Under Review
Approved
Rejected

Possible workflow:

Pending
↓
Awaiting Payment
↓
Under Review
↓
Approved
↓
Shipment Created

Or:

Pending
↓
Under Review
↓
Rejected

Once a request is approved:

Request
↓
Shipment

==================================================
18. SHIPMENT WORKFLOW
    ==================================================

Shipment section will be:

Shipments
├── All Shipments
├── Active
├── In Transit
├── Delivered
└── Shipment Details

Possible shipment statuses:

Processing
Picked Up
In Transit
Customs Clearance
Out for Delivery
Delivered
Cancelled

Service-specific workflows may differ.

Do not force every service to use exactly the same timeline.

==================================================
19. CLIENT TRACKING
    ==================================================

The client should eventually be able to enter:

Tracking Number

and click:

Track Now

The client should see:

Shipment ID
Product
Service
Origin
Destination
Current Status
Estimated Delivery
Complete Timeline

Example:

Request Submitted
↓
Payment Confirmed
↓
Approved
↓
Shipment Created
↓
Picked Up
↓
In Transit
↓
Customs Clearance
↓
Out for Delivery
↓
Delivered

==================================================
20. NEXT DEVELOPMENT ORDER
    ==================================================

The next pages should be developed in this order:

1. Requests → Create Request
   ALREADY DONE

2. Shipments → All Shipments
   NEXT MAJOR PAGE

3. Shipments → Shipment Details

4. Tracking

5. Services → All Services

6. Services → Add Service

7. Services → Service Details

8. Payments

9. Invoices

10. Clients

11. Locations

12. Reports

13. Profile

14. Settings

15. Client Dashboard

16. Client Request Creation

17. Client Payment Flow

18. Client Tracking

==================================================
21. HOW TO BUILD EACH PAGE
    ==================================================

When I ask for a page, provide:

1. Complete Blade/HTML
2. Complete SCSS
3. Use existing variables
4. Use existing mq() mixin
5. Use existing typography system
6. Use Remix Icons
7. Make it responsive
8. Keep class naming consistent
9. Use realistic demo data
10. Do not change existing project design language

Do not provide only snippets unless I specifically ask for snippets.

If I ask:
"HTML and SCSS daw"

Give the full HTML/Blade and full SCSS.

==================================================
22. HTML RULES
    ==================================================

Use clean semantic HTML.

Use Blade syntax where appropriate.

Example:

<a href="{{ route('dashboard') }}">

Use:

@csrf

inside POST forms.

Use buttons for actions.

Use anchors for navigation.

Use proper labels for inputs.

Use meaningful placeholder text.

Do not use unnecessary inline CSS.

Do not put huge amounts of styling directly inside HTML.

==================================================
23. SCSS RULES
    ==================================================

Use nested SCSS.

Example:

.example-card {

    h2 {
        font-size: 30px;

        @include mq(lg) {
            font-size: 20px;
        }

        @include mq(xs) {
            font-size: 18px;
        }
    }
}

Use section comments like:

/*================================*
* Page Header
  *=================================*/

Keep SCSS organized by component.

Do not create a completely different SCSS architecture.

Use:

$theme-color
$heading-color
$body-color
$light
$success
$warning
$danger
$info

Use:

argb($theme-color, 0.08)

instead of manually creating many rgba colors where possible.

==================================================
24. DATA TABLE RULE
    ==================================================

Requests and other listing pages should use DataTables.

Do not build fake pagination manually.

Use DataTables for:

- Search
- Pagination
- Page length
- Sorting
- Table controls

Maintain the same visual styling as the Requests DataTable.

==================================================
25. IMPORTANT UX RULES
    ==================================================

Every listing page should have:

Page title
Description
Primary action
Statistics where useful
DataTable/list
Search/filter where appropriate
Status badges
View/details action

Every details page should have:

Page header
Back button
Status
Summary
Main information cards
Timeline where applicable
Action buttons
Related entity links

Every create page should have:

Clear page title
Step/section numbering where useful
Grouped form cards
Required field indicators
Validation-friendly structure
Summary/total section
Cancel button
Primary submit button

==================================================
26. FUTURE SERVICE EXTENSIBILITY
    ==================================================

The architecture should support adding services without redesigning the entire UI.

Current:

Freight Forwarding
Customs Clearance

Future:

Warehousing
Distribution

Potential future services should be able to be added from:

Services → Add Service

Therefore avoid hardcoding the entire business logic around only two services.

==================================================
27. CURRENT DESIGN PRINCIPLE
    ==================================================

The UI is NOT supposed to look like a generic Bootstrap admin template.

It should feel like a custom logistics platform.

Use:

- Strong navy headings
- Green primary actions
- White cards
- Light gray background
- Compact but readable dashboard tables
- Clear status badges
- Clean timelines
- Good spacing
- Professional form controls
- Rounded 8–14px cards
- Subtle shadows
- Minimal visual noise

==================================================
28. IMPORTANT: DO NOT DO THESE
    ==================================================

Do NOT:

- Change the color palette
- Introduce Tailwind
- Introduce another CSS framework
- Replace DataTables
- Replace Poppins
- Create a new typography system
- Use random font sizes
- Make desktop typography extremely small
- Create unnecessary animations
- Redesign the sidebar
- Change existing class names without reason
- Break existing responsive behavior
- Rebuild already completed pages unnecessarily

==================================================
29. CURRENT STATE
    ==================================================

Current development status:

Dashboard:
DONE

Sidebar:
DONE

Requests → All Requests:
DONE

Requests → Request Details:
DONE

Requests → Create Request:
DONE

Next:
Shipments → All Shipments

Then:
Shipment Details
Tracking
Services
Payments
Invoices
Clients
Locations
Reports
Settings
Client-side system

==================================================
30. WHEN I SAY "NEXT PAGE"
    ==================================================

If I say:

"next page"

Do NOT ask me to explain the whole project again.

Use this master context.

Determine the next logical page based on the current workflow.

If the previous page was:

Requests → Create Request

then the next page should normally be:

Shipments → All Shipments

Unless I explicitly tell you another page.

==================================================
31. WHEN I ASK FOR UI/UX
    ==================================================

First think about:

- User role
- Business workflow
- Data relationships
- Page purpose
- Primary action
- Secondary actions
- Status
- Timeline
- Responsive layout

Then create the UI.

Do not create decorative UI that does not support the business workflow.

==================================================
32. RESPONSE STYLE
    ==================================================

I prefer direct answers.

If I ask for HTML + SCSS:

Give me complete code.

If something needs JS:

Give the required JS separately.

If something needs Laravel backend:

First finish the UI unless I explicitly ask for backend/database code.

Do not over-explain.

Keep the code production-friendly.

==================================================
33. CURRENT TASK
    ==================================================

Continue from the current project state.

The latest completed page is:

Requests → Create Request

The next planned page is:

Shipments → All Shipments

When I ask for the next page, continue from there using all rules above.

Remember:
The Requests page typography is the master reference for all future dashboard pages.
Responsive SCSS must use the existing mq() mixin.
Use the existing SCSS variables.
Keep the same Baobab Atlas visual language.
















Read the master project context above.

Continue from the current project state.

Now create the next page:
Shipments → All Shipments

Give me:
1. Complete Blade/HTML
2. Complete SCSS
3. Realistic demo data
4. Responsive design using the existing mq() mixin

Follow the existing Requests page typography and design system exactly.

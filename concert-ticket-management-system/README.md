# Concert Ticket Management System - Project Specifications

## Overview
Build a Laravel-based REST API for a concert ticket management system that handles polymorphic relationships, complex validations, and time-based reservations.

## Core Requirements

### Database Structure
Implement the following tables with proper relationships:

- **users** - Individual buyers
- **companies** - Corporate buyers  
- **events** - Concert events
- **ticket_categories** - Different ticket types per event
- **reservations** - Temporary ticket holds (5-minute expiry)
- **tickets** - Final purchased tickets with polymorphic purchasable relationship
- **personal_access_tokens** - Simple token authentication

### Key Polymorphic Relationships
- `tickets.purchasable_type/purchasable_id` - Links tickets to either User or Company models
- Implement proper Laravel morphTo/morphMany relationships

### Authentication System
- Random string token-based authentication (not JWT)
- Bearer token middleware for protected endpoints
- Registration with complex validation rules
- Login generating random string tokens

### Time-Based Reservation Logic
- 5-minute ticket hold system
- Concurrent reservation handling
- Automatic expiration of unreserved tickets
- Prevention of double-booking

### Complex Validation Rules

#### Registration Validations
- Email unique and valid format
- Password minimum 8 characters with uppercase, lowercase, number
- Phone valid international format
- Age 13+ (COPPA compliance)

#### Business Logic Validations
- Event sale period enforcement
- Ticket availability checks
- Age restrictions per event
- Maximum 8 tickets per reservation
- No duplicate active reservations per user/event
- Company employee authorization checks

### API Endpoints (10 total)

1. `POST /auth/register` - User registration
2. `POST /auth/login` - User authentication
3. `GET /events` - List events with filtering/pagination
4. `GET /events/{id}` - Event details with ticket categories
5. `POST /events/{id}/reserve` - Create ticket reservation
6. `POST /reservations/{id}/confirm` - Confirm reservation and create tickets
7. `DELETE /reservations/{id}/cancel` - Cancel active reservation
8. `GET /tickets` - User's tickets
9. `GET /tickets/{id}` - Ticket details with QR code
10. `GET /companies/{id}/tickets` - Company tickets

### Required Features

#### Ticket Reservation Flow
1. User creates reservation (5-minute hold)
2. Tickets temporarily unavailable to others
3. User must confirm within 5 minutes
4. Automatic cleanup of expired reservations

#### Polymorphic Purchasing
- Users can buy tickets individually
- Companies can buy tickets for employees
- Proper relationship handling in all endpoints

#### Data Seeding
Create comprehensive seeders that include:
- **At least 10 predefined concert events** with varying:
  - Dates (past, current, future)
  - Cities and venues
  - Age restrictions
  - Capacity limits
  - Sale periods
- Multiple ticket categories per event (VIP, General, Standing, etc.)
- Sample companies with employee relationships
- Test users with various ages

### Technical Constraints

#### Database
- Use Laravel migrations
- Implement proper foreign key constraints
- Index frequently queried columns
- Handle soft deletes where appropriate

#### Code Quality
- Follow Laravel conventions
- Implement proper error handling
- Use Laravel's validation features
- Resource controllers and form requests
- API resources for response formatting

#### Security
- Protect against race conditions in reservations
- Validate ownership of reservations/tickets
- Sanitize all inputs
- Rate limiting on authentication endpoints

## Expected Challenges

The developer must solve these without guidance:

1. **Polymorphic Relationships** - Proper implementation of morphTo/morphMany
2. **Concurrent Reservations** - Database transactions and locking
3. **Time-Based Expiration** - Background job scheduling or real-time checks
4. **Complex Validations** - Custom validation rules and business logic
5. **Authorization Logic** - Company employee access control
6. **Data Integrity** - Ensuring ticket availability accuracy under load

## Deliverables

- Fully functional Laravel API matching the OpenAPI specification
- Database migrations and seeders with predefined events
- Comprehensive validation and error handling
- Working polymorphic relationships
- Time-based reservation system
- Token-based authentication system

## Testing Requirements

The API should handle:
- Multiple concurrent reservation attempts
- Expired reservation cleanup
- Edge cases in ticket availability
- Proper polymorphic relationship queries
- Authorization boundary testing

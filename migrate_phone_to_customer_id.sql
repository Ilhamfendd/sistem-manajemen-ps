-- Migration: Replace phone column with customer_id
-- Date: 2025-12-17
-- Purpose: Replace customer phone number with auto-generated customer ID (YYNNNN format)

-- Add new customer_id column (nullable temporarily)
ALTER TABLE customers ADD COLUMN customer_id VARCHAR(6) UNIQUE NULL AFTER id;

-- Add index for faster lookups
CREATE INDEX idx_customer_id ON customers(customer_id);

-- Drop phone column
ALTER TABLE customers DROP COLUMN phone;

-- Make customer_id NOT NULL after all rows are migrated
-- This will be done after generating IDs for existing customers (if any)

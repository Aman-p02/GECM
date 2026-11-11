# Current Project Status

**Date**: 2026-11-11
**Current Phase**: Phase 5 — Core Features & Department CMS Modules

## Recent Work Completed:
1. **Department Faculty Management Module**:
   - Full CRUD in `admin/dept-faculty.php` supporting all departments.
   - Dynamic seeding of 24 CE faculties with detailed qualifications.
   - Shared frontend component `departments/includes/faculty-tab.php` and unified profile `faculty-profile.php`.

2. **Department Activities Module**:
   - Table `department_activities` in database.
   - Full CRUD in `admin/dept-activities.php` with image uploads, display order, date picker, search filter, and toggle/delete actions.
   - Alternating modern timeline component (`departments/includes/activities-tab.php`, `activities.css`) active across all 6 departments.
   - Fixed upload helper array type handling and admin sidebar active states.

3. **Department Research Publications Module**:
   - Table `department_publications` created in database.
   - Full CRUD in `admin/dept-publications.php` with title, authors/members, publication date, 4-digit filter year, journal details, paper link, and order.
   - Migrated all 153 Computer Engineering publications into the database.
   - Reusable frontend component at `departments/includes/publications-tab.php` with year filtering toolbar and card layout matching the reference design.
   - Connected and verified across all 6 departments (`computer`, `information-technology`, `civil`, `mechanical`, `automobile`, `applied-mechanics`).

## Next Steps:
- Advisory Board & Newsletters modules.
- Verification and audit of remaining department features.

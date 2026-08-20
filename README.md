# Attest

Attest is a PHP-based test case management and test execution dashboard. It helps QA and engineering teams organize test plans, build test labs for release or ad hoc runs, track manual and automated execution results, and review reporting around coverage and failures.

The application is split into a server-rendered PHP UI and a JSON API built with Slim 3. Data is stored in MySQL using the `attest` schema provided in `attest.sql`.

## What It Does

- Manages test plan hierarchies using product and module nodes.
- Stores test cases with metadata such as owner, type, category, priority, tags, scrum name, automation status, automation script path, and linked feature IDs.
- Supports CSV upload for bulk test creation.
- Creates test lab runs from selected tests.
- Tracks run status, execution date, bug IDs, and test run links.
- Provides dashboards and reports for test category distribution, run types, recent runs, top failures, and frequent test failures.
- Integrates with Okta for UI login.
- Can trigger Jenkins jobs for automated tests by collecting ready automation script paths from a test lab node.
- Includes helper actions for reporting issues through Jira-related configuration.

## Main Screens

- `index.php` - dashboard with high-level test and run summaries.
- `login.php` - Okta-backed login flow and local user registration.
- `test-plan.php` - browse, add, upload, and delete test cases by test plan node.
- `test-plan-details.php` - edit test details, steps, expected output, automation metadata, and feature links.
- `test-lab.php` - manage execution runs and update pass/fail state.
- `features.php` - maintain feature records that can be associated with tests.
- `reports.php` - report container for failure and run analytics.
- `sast-dashboard.php` - SAST-oriented dashboard page.

## Project Structure

```text
.
|-- api/
|   |-- index.php                  # Slim API entry point
|   |-- composer.json              # API dependencies
|   `-- src/
|       |-- config/                # Database and service configuration
|       |-- functions.php          # HTTP, CSV, Jenkins/Jira helper methods
|       `-- routes/                # API route modules and auth middleware
|-- actions/                       # UI form handlers that call the API
|-- partials/                      # Shared UI pieces, menus, modals, headers
|-- report-partials/               # Report-specific UI fragments
|-- assets/, bootstrap/, plugins/   # Frontend assets and third-party UI libraries
|-- sass/                          # Source Sass files for bundled styles
|-- uploads/                       # CSV upload location
|-- attest.sql                     # Database schema and seed data
|-- db_changes.txt                 # Database change notes
`-- attest.postman_collection.json # Postman collection for API calls
```

## Technology Stack

- PHP
- Slim Framework 3 for REST API routes
- MySQL through PDO
- Bootstrap, jQuery, DataTables, Select2, ApexCharts, and other bundled UI plugins
- Okta authentication for the UI
- Jenkins integration for automated test execution
- Jira-related helpers for issue reporting
- SendGrid dependency included in `api/composer.json`

## Local Setup

These steps assume a local PHP and MySQL environment such as Apache, MAMP, XAMPP, or PHP's built-in server with URL rewriting handled appropriately.

1. Clone the repository into your web root or local workspace.

2. Create the database and import the schema:

   ```sql
   CREATE DATABASE attest;
   USE attest;
   SOURCE attest.sql;
   ```

3. Install API dependencies if `api/vendor` is not present or needs to be refreshed:

   ```bash
   cd api
   composer install
   ```

4. Review local configuration:

   - `api/src/config/db.php` contains the MySQL host, database name, username, and password.
   - `api/src/config/init.php` contains `BASE_URL` and external service URLs.

5. Set `BASE_URL` in `api/src/config/init.php` to the URL where the app is served. The checked-in local default is:

   ```php
   define('BASE_URL','http://localhost/attest');
   ```

6. Open the app in a browser:

   ```text
   http://localhost/attest
   ```

## API Overview

The API entry point is `api/index.php`. Most routes return JSON and are protected by Basic auth middleware, with credentials checked against `tcm_users`.

Primary route groups:

- `GET /api/site_options/{key}`
- `GET /api/users`
- `GET /api/users/login`
- `POST /api/users`
- `PATCH /api/users`
- `DELETE /api/users`
- `GET /api/nodes`
- `GET /api/nodes/root`
- `POST /api/nodes`
- `PATCH /api/nodes/{id}`
- `DELETE /api/nodes/{id}`
- `GET /api/tests`
- `POST /api/tests`
- `PATCH /api/tests/{id}`
- `DELETE /api/tests/{id}`
- `GET /api/history/{id}`
- `POST /api/upload-tests/{product}/{node}`
- `GET /api/releases/{parent_node}`
- `POST /api/releases`
- `PATCH /api/releases/{parent_node}/{test_id}`
- `DELETE /api/releases/{parent_node}/{test_id}`
- `GET /api/features`
- `POST /api/features`
- `PATCH /api/features/{feature_id}`
- `DELETE /api/features/{feature_id}`
- `GET /api/reports/tests-by-category`
- `GET /api/reports/test-runs-by-type`
- `GET /api/reports/lastest-runs`
- `GET /api/reports/recent-run-dates`
- `GET /api/reports/most-failures`
- `GET /api/reports/frequent-test-failures`

The Postman collection in `attest.postman_collection.json` can be used as a starting point for manual API exploration.

## Database

The schema in `attest.sql` defines the core tables:

- `tcm_users` - users and API authentication records.
- `tcm_nodes` - test plan and test lab tree nodes.
- `tcm_tests` - test case definitions and automation metadata.
- `tcm_releases` - test run records by lab node and test.
- `tcm_features` - feature or requirement records linked to tests.
- `tcm_options` - site-level options such as the displayed site name.

Most records use an `is_deleted` field for soft deletion.

## CSV Uploads

Bulk test upload is handled through the UI and `POST /api/upload-tests/{product}/{node}`. Uploaded files are stored under `uploads/`, then converted from CSV into JSON before insert.

Expected CSV fields map to the test columns used in `api/src/routes/modules/tests.php`, including:

- `name`
- `description`
- `author`
- `test_type`
- `test_category`
- `priority`
- `scrum_name`
- `steps`
- `expected_output`
- `automation_status`
- `automation_script_path`
- `automation_author`
- `tag`
- `feature_id`

## Automation Runs

`actions/executeAutomationTests.php` reads all tests from a selected test lab node, filters for tests where:

- `test_type` is `Automation`
- `automation_status` is `Ready`
- `automation_script_path` is present

It then builds a Jenkins `buildWithParameters` request using those script paths as `--spec` values.

## Development Notes

- The UI pages are mostly server-rendered PHP and call the local API through `CallToAction` helpers in `api/src/functions.php`.
- Shared page chrome lives in `partials/`.
- API modules are organized by domain in `api/src/routes/modules/`.
- The database connection currently uses hard-coded local credentials in `api/src/config/db.php`.
- External service credentials and endpoints are defined in `api/src/config/init.php`; review and replace them for your environment before running integrations.
- Several third-party frontend and PHP dependencies are checked into the repository.

## Security Notes

Before deploying or sharing this project outside a trusted environment:

- Move database and external service credentials out of source control and into environment-specific configuration.
- Rotate any credentials that have been committed.
- Review API input handling before exposing the app publicly.
- Restrict CORS in `api/index.php` to trusted origins.
- Ensure uploaded CSV files are validated and access controlled.

## Naming Notes

Some API and report names preserve existing spelling for compatibility, such as `/api/reports/lastest-runs`.

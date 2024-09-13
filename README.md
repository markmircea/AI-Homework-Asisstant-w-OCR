AI Homework Assistant, Google OAUTH for login/registration. Multi AI model image and text analysis. Advanced history search for previous queries. Full profile including active sessions and tier management based on free or paid subscription. 
![image](https://github.com/user-attachments/assets/634a0677-7a46-4ad8-8412-7d306f5e6b66)
![image](https://github.com/user-attachments/assets/36e05ebb-3b18-419c-9cf0-89b5b0dd245e)


## Installation


Install PHP dependencies:

```sh
composer install
```

Install NPM dependencies:

```sh
npm ci
```

Build assets:

```sh
npm run dev
```

Setup configuration:

```sh
cp .env.example .env
```

Generate application key:

```sh
php artisan key:generate
```

Create an SQLite database. You can also use another database (MySQL, Postgres), simply update your configuration accordingly.

```sh
touch database/database.sqlite
```

Run database migrations:

```sh
php artisan migrate
```

Run database seeder:

```sh
php artisan db:seed
```

Run the dev server (the output will give the address):

```sh
php artisan serve
```

You're ready to go!  in your browser, and login with:

- **Username:** johndoe@example.com
- **Password:** secret

## Running tests

To run the tests, run:

```
phpunit
```


```
Directory Structure
```

c:\wamp64\www\pingfresh\pingcrm-master
│
├── .editorconfig
├── .env.example
├── .eslintrc.js
├── .gitattributes
├── .gitignore
├── .prettierrc
├── artisan
├── composer.json
├── composer.lock
├── LICENSE.md
├── package-lock.json
├── package.json
├── phpstan.neon
├── phpunit.xml
├── postcss.config.js
├── Procfile
├── README.md
├── screenshot.png
├── tailwind.config.js
├── vite.config.js
├── w.md
│
├── app
│ ├── Http
│ │ ├── Controllers
│ │ │ ├── Auth
│ │ │ │ ├── AuthenticatedSessionController.php
│ │ │ │ └── PasswordResetController.php
│ │ │ ├── AnnouncementController.php
│ │ │ ├── AskController.php
│ │ │ ├── askcontrollerpdf
│ │ │ ├── ContactsController.php
│ │ │ ├── Controller.php
│ │ │ ├── DashboardController.php
│ │ │ ├── HistoryController.php
│ │ │ ├── HistoryListController.php
│ │ │ ├── ImagesController.php
│ │ │ ├── OCRController.php
│ │ │ ├── OCRMController.php
│ │ │ ├── OpenAIController.php
│ │ │ ├── OrganizationsController.php
│ │ │ ├── PayPalWebhookController.php
│ │ │ ├── PricingController.php
│ │ │ ├── ProfileController.php
│ │ │ ├── PublicAskController.php
│ │ │ ├── PublicAskControllerwAZURE.php
│ │ │ ├── ReportsController.php
│ │ │ ├── SubscriptionController.php
│ │ │ ├── UsersController.php
│ │ │ └── UserSessionController.php
│ │ ├── Middleware
│ │ │ ├── CheckOwner.php
│ │ │ ├── HandleInertiaRequests.php
│ │ │ ├── ShareCoins.php
│ │ │ └── TrustProxies.php
│ │ └── Requests
│ │ └── Auth
│ │ └── LoginRequest.php
│ ├── Mail
│ ├── Models
│ │ ├── Account.php
│ │ ├── Announcement.php
│ │ ├── Contact.php
│ │ ├── DailyQuestionCount.php
│ │ ├── Organization.php
│ │ ├── PublicQuestionCount.php
│ │ └── User.php
│ ├── Notifications
│ │ ├── CancelSubscription.php
│ │ ├── ContactFormSubmission.php
│ │ ├── CustomVerifyEmail.php
│ │ └── RegistrationConfirmation.php
│ ├── Policies
│ ├── Providers
│ │ └── AppServiceProvider.php
│ └── Traits
│
├── bootstrap
│ ├── app.php
│ ├── cache
│ │ └── .gitignore
│ └── providers.php
│
├── config
│ ├── .gitkeep
│ ├── database.php
│ ├── inertia.php
│ ├── mail.php
│ ├── sanctum.php
│ └── services.php
│
├── database
│ ├── .gitignore
│ ├── factories
│ │ ├── ContactFactory.php
│ │ ├── OrganizationFactory.php
│ │ └── UserFactory.php
│ ├── migrations
│ │ ├── 2019_12_14_000001_create_personal_access_tokens_table.php
│ │ ├── 2020_01_01_000001_create_password_resets_table.php
│ │ ├── 2020_01_01_000002_create_failed_jobs_table.php
│ │ ├── 2020_01_01_000003_create_accounts_table.php
│ │ ├── 2020_01_01_000004_create_users_table.php
│ │ ├── 2020_01_01_000005_create_organizations_table.php
│ │ ├── 2020_01_01_000006_create_contacts_table.php
│ │ ├── 2024_04_02_000000_add_expires_at_to_personal_access_tokens_table.php
│ │ ├── 2024_04_02_000000_rename_password_resets_table.php
│ │ ├── 2024_07_01_141345_add_google_id_to_users.php
│ │ ├── 2024_07_09_121942_create_announcements_table.php
│ │ ├── 2024_07_25_153347_create_sessions_table.php
│ │ ├── 2024_08_04_124700_add_new_table_daily_question_counts.php
│ │ ├── 2024_08_04_130234_add_column_subscription_type_to_users_table.php
│ │ ├── 2024_08_05_143633_create_public_question_counts_table.php
│ │ ├── 2024_08_05_153624_add_index_to_public_question_counts.php
│ │ └── 2024_08_27_092950_add_paypal_subscription_id_to_users_table.php
│ └── seeders
│ └── DatabaseSeeder.php
│
├── public
│ ├── .htaccess
│ ├── favicon.svg
│ ├── img
│ │ ├── announcements
│ │ ├── boostpre.jpeg
│ │ └── studentest.jpeg
│ ├── index.php
│ └── robots.txt
│
├── resources
│ ├── css
│ │ ├── app.css
│ │ ├── buttons.css
│ │ └── form.css
│ ├── html
│ │ ├── .gitignore
│ │ ├── android-chrome-192x192.png
│ │ ├── android-chrome-512x512.png
│ │ ├── apple-touch-icon.png
│ │ ├── browserconfig.xml
│ │ ├── favicon-16x16.png
│ │ ├── favicon-32x32.png
│ │ ├── favicon.ico
│ │ ├── images
│ │ │ ├── feature-1.png
│ │ │ ├── feature-2.png
│ │ │ ├── hero.png
│ │ │ └── logo.svg
│ │ ├── index.html
│ │ ├── input.css
│ │ ├── LICENSE
│ │ ├── mstile-150x150.png
│ │ ├── output.css
│ │ ├── package-lock.json
│ │ ├── package.json
│ │ ├── README.md
│ │ ├── site.webmanifest
│ │ └── tailwind.config.js
│ ├── images
│ │ ├── boostpre.jpeg
│ │ ├── compare.svg
│ │ └── studentest.jpeg
│ ├── js
│ │ ├── app.js
│ │ ├── directives
│ │ │ └── resizable.js
│ │ ├── Pages
│ │ │ ├── Announcements
│ │ │ │ ├── Create.vue
│ │ │ │ ├── Edit.vue
│ │ │ │ └── OCR.vue
│ │ │ ├── Ask
│ │ │ │ ├── Index.vue
│ │ │ │ ├── indexcopy.vue
│ │ │ │ ├── indexcopy1
│ │ │ │ └── Upload.vue
│ │ │ ├── Auth
│ │ │ │ ├── ForgotPassword.vue
│ │ │ │ ├── Login.vue
│ │ │ │ ├── Register.vue
│ │ │ │ ├── ResetPasswordPage.vue
│ │ │ │ └── VerifyEmail.vue
│ │ │ ├── Contacts
│ │ │ │ ├── Create.vue
│ │ │ │ ├── Edit.vue
│ │ │ │ └── Index.vue
│ │ │ ├── Dashboard
│ │ │ │ ├── BlackBar.vue
│ │ │ │ ├── ContactUs.vue
│ │ │ │ ├── DarkDivider.vue
│ │ │ │ ├── FeatureSection.vue
│ │ │ │ ├── Footer.vue
│ │ │ │ ├── Hero.vue
│ │ │ │ ├── Index.vue
│ │ │ │ ├── IndexNoAuth.vue
│ │ │ │ ├── Nav.vue
│ │ │ │ ├── Pricing.vue
│ │ │ │ ├── PricingPage.vue
│ │ │ │ ├── PublicAsk.vue
│ │ │ │ ├── PublicNav.vue
│ │ │ │ └── Steps.vue
│ │ │ ├── History
│ │ │ │ ├── Edit.vue
│ │ │ │ ├── Index.vue
│ │ │ │ ├── List.vue
│ │ │ │ ├── ListEdit.vue
│ │ │ │ └── OCR.vue
│ │ │ ├── Legal
│ │ │ │ ├── PrivacyPolicy.vue
│ │ │ │ └── TermsOfService.vue
│ │ │ ├── Organizations
│ │ │ │ ├── Create.vue
│ │ │ │ ├── Edit.vue
│ │ │ │ └── Index.vue
│ │ │ ├── Profile
│ │ │ │ ├── Account.vue
│ │ │ │ └── ActiveSessions.vue
│ │ │ ├── Reports
│ │ │ │ ├── Edit.vue
│ │ │ │ └── Index.vue
│ │ │ └── Users
│ │ │ ├── Account.vue
│ │ │ ├── ActiveSessions.vue
│ │ │ ├── Create.vue
│ │ │ ├── Edit.vue
│ │ │ └── Index.vue
│ │ ├── Shared
│ │ │ ├── Dropdown.vue
│ │ │ ├── EmailForm.vue
│ │ │ ├── FileInput.vue
│ │ │ ├── FileUpload.vue
│ │ │ ├── FlashMessages.vue
│ │ │ ├── FullPageLoader.vue
│ │ │ ├── Icon.vue
│ │ │ ├── ImageUpload.vue
│ │ │ ├── Layout.vue
│ │ │ ├── Loading.vue
│ │ │ ├── LoadingButton.vue
│ │ │ ├── Logo.vue
│ │ │ ├── MainMenu.vue
│ │ │ ├── Modal.vue
│ │ │ ├── Pagination.vue
│ │ │ ├── SearchFilter.vue
│ │ │ ├── SelectInput.vue
│ │ │ ├── TextareaInput.vue
│ │ │ ├── TextInput.vue
│ │ │ └── TrashedMessage.vue
│ │ └── ssr.js
│ └── views
│ ├── app.blade.php
│ └── emails
│ └── registration-confirmation.blade.php
│
├── routes
│ ├── console.php
│ └── web.php
│
├── storage
│ ├── app
│ │ ├── .gitignore
│ │ └── public
│ │ └── .gitignore
│ ├── debugbar
│ │ └── .gitignore
│ ├── framework
│ │ ├── .gitignore
│ │ ├── cache
│ │ │ ├── .gitignore
│ │ │ └── data
│ │ │ └── .gitignore
│ │ ├── sessions
│ │ │ └── .gitignore
│ │ ├── testing
│ │ │ └── .gitignore
│ │ └── views
│ │ └── .gitignore
│ └── logs
│ └── .gitignore
│
└── tests
├── Feature
│ ├── ContactsTest.php
│ └── OrganizationsTest.php
├── TestCase.php
└── Unit
└── ExampleTest.php

<x-app-layout>
    <div class="updating-container">
        <div class="updating-card">
            <!-- Animated Icon -->
            <div class="updating-icon">
                <svg class="spinner" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="spinner-track" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="spinner-path" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>

            <!-- Heading -->
            <h2 class="updating-title">Updating</h2>
            
            <!-- Description -->
            <p class="updating-description">
                We're currently updating this page.
            </p>

        </div>

    </div>

    <style>
        .updating-container {
            min-height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .updating-card {
            max-width: 28rem;
            width: 100%;
            border-radius: 1rem;
            padding: 2rem;
            text-align: center;
        }

        .updating-icon {
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: center;
        }

        .spinner {
            height: 4rem;
            width: 4rem;
            color: #4f46e5;
            animation: spin 1s linear infinite;
        }

        .spinner-track {
            opacity: 0.25;
        }

        .spinner-path {
            opacity: 0.75;
        }

        .updating-title {
            font-size: 1.875rem;
            font-weight: bold;
            color: #111827;
            margin-bottom: 0.75rem;
        }

        .updating-description {
            color: #4b5563;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .updating-progress-wrapper {
            margin-bottom: 1.5rem;
        }

        .progress-bar-container {
            width: 100%;
            background-color: #e5e7eb;
            border-radius: 9999px;
            height: 0.625rem;
            overflow: hidden;
        }

        .progress-bar {
            background-color: #4f46e5;
            height: 100%;
            border-radius: 9999px;
            width: 65%;
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        .progress-text {
            font-size: 0.875rem;
            color: #6b7280;
            margin-top: 0.5rem;
        }

        .updating-notice {
            background-color: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 0.5rem;
            padding: 1rem;
        }

        .updating-notice p {
            font-size: 0.875rem;
            color: #1e40af;
            margin: 0;
        }

        .updating-footer {
            text-align: center;
            color: #6b7280;
            font-size: 0.875rem;
            margin-top: 1.5rem;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>
</x-app-layout>
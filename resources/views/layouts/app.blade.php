<!DOCTYPE html>
<html lang="en" class="h-full bg-[#f4f6f4] text-[#131e18]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#133e2b">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="icon" href="{{ asset('icons/loomflow.svg') }}" type="image/svg+xml">
    <title>@yield('title', 'LoomFlow') - LoomFlow</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        zinc: {
                            50: '#f5f7f5',
                            100: '#edf2ec',
                            200: '#e2e8e0',
                            300: '#cbd6cb',
                            400: '#8fa699',
                            500: '#647b6e',
                            600: '#385747',
                            700: '#1b4835',
                            800: '#143829',
                            900: '#133e2b',
                            950: '#0b261a'
                        },
                        forest: {
                            DEFAULT: '#133e2b',
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#133e2b',
                            950: '#0b261a',
                            card: '#184a34',
                            hover: '#1e543b',
                            border: '#205c41'
                        },
                        lime: {
                            DEFAULT: '#c6f16d',
                            accent: '#c6f16d',
                            hover: '#b5e759'
                        },
                        surface: '#f4f6f4'
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    },
                }
            }
        }
    </script>

    <style>
        :root {
            --brand-forest: #133e2b;
            --brand-accent: #c6f16d;
            --brand-surface: #f4f6f4;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f4f6f4;
            color: #131e18;
            min-height: 100vh;
        }
        .card {
            background: #ffffff;
            border: 1px solid #e2e8e0;
            border-radius: 1.25rem;
        }
        .card-hover {
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px -8px rgba(19, 62, 43, 0.08);
            border-color: #cbd5c8;
        }
        .glass-card {
            background: #ffffff;
            border: 1px solid #e2e8e0;
            border-radius: 1.25rem;
        }
        .glass-card-hover {
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .glass-card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px -8px rgba(19, 62, 43, 0.08);
            border-color: #cbd5c8;
        }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; height: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #0e2d20; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #236548; border-radius: 9999px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #318a63; }
        
        .main-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .main-scrollbar::-webkit-scrollbar-track { background: #f4f6f4; }
        .main-scrollbar::-webkit-scrollbar-thumb { background: #d0d7cf; border-radius: 9999px; }
        .main-scrollbar::-webkit-scrollbar-thumb:hover { background: #aebdb0; }

        @media (min-width: 1024px) {
            #appSidebar.sidebar-collapsed {
                width: 5rem;
            }

            #appSidebar.sidebar-collapsed .sidebar-section-label,
            #appSidebar.sidebar-collapsed .sidebar-header-title,
            #appSidebar.sidebar-collapsed .sidebar-link-label,
            #appSidebar.sidebar-collapsed .sidebar-operator-copy {
                display: none;
            }

            #appSidebar.sidebar-collapsed .sidebar-brand-header {
                justify-content: center;
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }

            #appSidebar.sidebar-collapsed .sidebar-brand-header {
                position: relative;
                overflow: visible;
                justify-content: center;
                padding-top: 0.75rem;
                padding-bottom: 0.75rem;
            }

            #appSidebar.sidebar-collapsed .sidebar-collapse-toggle {
                display: flex;
            }

            #appSidebar.sidebar-collapsed .sidebar-nav {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }

            #appSidebar.sidebar-collapsed .sidebar-nav a {
                position: relative;
                justify-content: center;
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }

            #appSidebar.sidebar-collapsed .sidebar-logout-button {
                position: relative;
            }

            #appSidebar.sidebar-collapsed .sidebar-operator-panel {
                display: flex;
                justify-content: center;
                padding: 0.75rem 0.5rem 1rem;
            }

            #appSidebar.sidebar-collapsed .sidebar-operator-card {
                width: 100%;
                padding: 0.25rem 0;
                border: 0;
                background: transparent;
            }

            #appSidebar.sidebar-collapsed .sidebar-user-info {
                display: none;
            }

            #appSidebar.sidebar-collapsed .sidebar-user-row {
                display: flex;
                flex-direction: column;
                width: 100%;
                justify-content: center;
                margin-top: 0;
                padding-top: 0;
                border-top: 0;
            }

            #appSidebar.sidebar-collapsed .sidebar-user-row form {
                display: flex;
                width: 100%;
                justify-content: center;
            }

            #appSidebar.sidebar-collapsed .sidebar-logout-button {
                position: relative;
                display: flex;
                flex: 0 0 auto;
                flex-direction: column;
                width: 3.5rem;
                min-width: 3.5rem;
                max-width: 3.5rem;
                height: 3.25rem;
                align-items: center;
                justify-content: center;
                margin: 0 auto;
                gap: 0.25rem;
                padding: 0.25rem;
                border: 1px solid #c6f16d;
                border-radius: 0.75rem;
                background: #184c35;
                color: #c6f16d;
                opacity: 1;
                visibility: visible;
            }

            #appSidebar.sidebar-collapsed .sidebar-logout-icon {
                display: block;
                width: 1.125rem;
                min-width: 1.125rem;
                height: 1.125rem;
                color: #c6f16d;
            }

            #appSidebar.sidebar-collapsed .sidebar-logout-label {
                display: block;
                color: #c6f16d;
                font-size: 0.55rem;
                font-weight: 800;
                line-height: 1;
                white-space: nowrap;
            }

            #appSidebar.sidebar-collapsed .sidebar-logout-button:hover,
            #appSidebar.sidebar-collapsed .sidebar-logout-button:focus-visible {
                border-color: #c6f16d;
                background: #184c35;
                color: #c6f16d;
            }

        }

        /* Traditional operator-console theme based on the supplied prototype. */
        body.operator-console {
            --operator-deep: #153e43;
            --operator-deep-soft: #24575a;
            --operator-edge: #b7c1c7;
            --operator-canvas: #e8ecee;
            --operator-muted: #627079;
            --operator-accent: #0f625d;
            --operator-highlight: #fff5c8;
            background: var(--operator-canvas) !important;
            color: #24333b !important;
            font-family: 'Segoe UI', Tahoma, sans-serif !important;
            font-size: 13px;
            height: 100%;
            overflow: hidden;
        }

        body.operator-console #appSidebar {
            background: #edf1f3 !important;
            color: #24333b !important;
            border-color: var(--operator-edge) !important;
            box-shadow: none !important;
        }

        body.operator-console .sidebar-brand-header,
        body.operator-console .sidebar-operator-panel {
            background: var(--operator-deep) !important;
            border-color: #38676b !important;
        }

        body.operator-console .sidebar-brand-header {
            min-height: 56px;
            justify-content: flex-end !important;
            padding: 8px 12px !important;
            border-bottom: 3px solid var(--operator-deep-soft) !important;
        }

        body.operator-console .sidebar-section-label {
            color: var(--operator-muted) !important;
            border-bottom: 1px solid var(--operator-edge);
            padding-bottom: 6px;
            letter-spacing: .08em !important;
        }

        body.operator-console .sidebar-nav {
            gap: 14px;
        }

        body.operator-console .sidebar-nav a {
            min-height: 34px;
            border-width: 1px !important;
            border-radius: 2px !important;
            color: #34434a !important;
            font-size: 12px !important;
            box-shadow: none !important;
        }

        body.operator-console .sidebar-nav a:hover {
            background: #fff !important;
            border-color: var(--operator-edge) !important;
            color: var(--operator-deep) !important;
        }

        body.operator-console .sidebar-nav a.shadow-md {
            background: #dce9e8 !important;
            border-color: #8eaaa9 !important;
            color: var(--operator-deep) !important;
            font-weight: 700 !important;
        }

        body.operator-console .sidebar-nav a svg {
            color: var(--operator-accent) !important;
        }

        .sidebar-shortcut-badge {
            flex: 0 0 auto;
            margin-left: auto;
            padding: 2px 4px;
            border: 1px solid #c5cfd2;
            border-radius: 2px;
            background: #f7f9fa;
            color: #627079;
            font: 10px Consolas, monospace;
        }

        body.operator-console #appSidebar.sidebar-collapsed .sidebar-shortcut-badge {
            display: none;
        }

        body.operator-console .sidebar-operator-card {
            border-radius: 2px !important;
            border-color: #38676b !important;
            background: #1d4b50 !important;
            box-shadow: none !important;
        }

        body.operator-console .sidebar-user-row {
            border-color: #38676b !important;
        }

        body.operator-console .sidebar-logout-button,
        body.operator-console .sidebar-collapse-toggle,
        body.operator-console #appSidebar button {
            border-radius: 2px !important;
        }

        body.operator-console > div > div.flex-1 > header {
            min-height: 56px;
            padding-top: 8px !important;
            padding-bottom: 8px !important;
            background: #fff !important;
            border-color: var(--operator-edge) !important;
            box-shadow: 0 1px 2px rgb(36 51 59 / 5%);
        }

        body.operator-console > div > div.flex-1 > header [class*="text-stone-400"] {
            color: var(--operator-muted) !important;
        }

        body.operator-console > div > div.flex-1 > header [class*="text-[#133e2b]"] {
            color: var(--operator-deep) !important;
        }

        body.operator-console > div > div.flex-1 > header [title] {
            border-radius: 2px !important;
            border-color: var(--operator-edge) !important;
            box-shadow: none !important;
        }

        body.operator-console > div > div.flex-1 > header [title] > div:first-child {
            border-radius: 2px !important;
            background: var(--operator-deep) !important;
            box-shadow: none !important;
        }

        body.operator-console main {
            padding: 18px 20px 24px !important;
            background: var(--operator-canvas);
        }

        body.operator-console main h1,
        body.operator-console main h2,
        body.operator-console main h3 {
            color: #24333b;
            letter-spacing: -.015em;
        }

        body.operator-console main .rounded-3xl,
        body.operator-console main .rounded-2xl,
        body.operator-console main .rounded-xl,
        body.operator-console main .rounded-lg,
        body.operator-console main .rounded-md {
            border-radius: 2px !important;
        }

        body.operator-console main .shadow-sm,
        body.operator-console main .shadow-md,
        body.operator-console main .shadow-lg,
        body.operator-console main .shadow-xl,
        body.operator-console main .shadow-2xl {
            box-shadow: 0 1px 2px rgb(36 51 59 / 6%) !important;
        }

        body.operator-console main input:not([type="checkbox"]):not([type="radio"]):not([type="hidden"]),
        body.operator-console main select,
        body.operator-console main textarea {
            min-height: 32px;
            border: 1px solid #aab9bd !important;
            border-radius: 1px !important;
            background-color: #fff;
            color: #24333b;
            padding: 6px 8px !important;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            font-size: 12px !important;
            box-shadow: inset 0 1px 1px rgb(36 51 59 / 4%) !important;
        }

        body.operator-console main textarea {
            min-height: 76px;
        }

        body.operator-console main input:focus,
        body.operator-console main select:focus,
        body.operator-console main textarea:focus {
            border-color: #bd8500 !important;
            outline: 2px solid rgb(255 215 102 / 38%);
            outline-offset: 0;
            box-shadow: none !important;
        }

        body.operator-console main label {
            color: #46565e;
            font-size: 11px;
            font-weight: 700;
        }

        body.operator-console main table {
            border-collapse: collapse;
            background: #fff;
        }

        body.operator-console main thead th {
            background: #edf1f3 !important;
            color: #45565d !important;
            border: 1px solid var(--operator-edge) !important;
            font-size: 10px;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        body.operator-console main tbody td {
            border: 1px solid #d7dfe2 !important;
        }

        body.operator-console main tbody tr:nth-child(even) {
            background: #f4f7f9;
        }

        body.operator-console main button,
        body.operator-console main a[class*="bg-[#133e2b]"],
        body.operator-console main a[class*="bg-[#0f625d]"] {
            border-radius: 2px !important;
        }

        body.operator-console footer {
            background: #edf1f3;
            border-color: var(--operator-edge) !important;
        }

        @media (max-width: 640px) {
            body.operator-console main {
                padding: 14px 12px 20px !important;
            }
        }

        body.operator-console > .operator-app {
            height: 100vh;
            height: 100dvh;
            min-height: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            padding-top: 74px;
        }

        body.operator-console.bags-display-mode {
            height: auto;
            overflow: visible;
        }

        body.operator-console.sizing-display-mode main form,
        body.operator-console.sizing-display-mode main button,
        body.operator-console.sizing-display-mode main a[href="#sizing-slip-entry"] {
            display: none !important;
        }

        body.operator-console.parts-display-mode main form,
        body.operator-console.parts-display-mode main button,
        body.operator-console.parts-display-mode main a[href="#part-add-entry"],
        body.operator-console.parts-display-mode main a[href="#part-issue-entry"] {
            display: none !important;
        }

        body.operator-console.fabric-display-mode main form,
        body.operator-console.fabric-display-mode main button,
        body.operator-console.fabric-display-mode main a[href="#fabric-stock-entry"],
        body.operator-console.fabric-display-mode main a[href="#fabric-loom-quality-entry"] {
            display: none !important;
        }

        body.operator-console.sales-display-mode main form,
        body.operator-console.sales-display-mode main button,
        body.operator-console.sales-display-mode main a[href^="#"] {
            display: none !important;
        }

        body.operator-console.finance-display-mode main form[method="POST"],
        body.operator-console.finance-display-mode main button,
        body.operator-console.finance-display-mode main a[href*="#"] {
            display: none !important;
        }

        body.operator-console.bags-display-mode > .operator-app {
            height: auto;
            min-height: 100vh;
            overflow: visible;
        }

        body.operator-console.sales-display-mode {
            height: auto;
            min-height: 100%;
            overflow: auto;
        }

        body.operator-console.finance-display-mode,
        body.operator-console.ledger-report-page,
        body.operator-console.factory-orders-display-mode,
        body.operator-console.factory-checking-display-mode,
        body.operator-console.factory-reports-display-mode,
        body.operator-console.production-display-mode {
            height: auto;
            min-height: 100%;
            overflow: auto;
        }

        body.operator-console.finance-display-mode > .operator-app,
        body.operator-console.finance-display-mode > .operator-app > .operator-workspace,
        body.operator-console.finance-display-mode > .operator-app > .operator-workspace > div.flex-1 {
            height: auto;
            min-height: 100vh;
            overflow: visible;
        }

        body.operator-console.finance-display-mode > .operator-app > .operator-workspace > div.flex-1 > main {
            flex: none;
            overflow: visible;
        }

        body.operator-console.ledger-report-page > .operator-app,
        body.operator-console.ledger-report-page > .operator-app > .operator-workspace,
        body.operator-console.ledger-report-page > .operator-app > .operator-workspace > div.flex-1 {
            height: auto;
            min-height: 100vh;
            overflow: visible;
        }

        body.operator-console.ledger-report-page > .operator-app > .operator-workspace > div.flex-1 > main {
            flex: none;
            overflow: visible;
        }

        body.operator-console.factory-orders-display-mode > .operator-app,
        body.operator-console.factory-orders-display-mode > .operator-app > .operator-workspace,
        body.operator-console.factory-orders-display-mode > .operator-app > .operator-workspace > div.flex-1 {
            height: auto;
            min-height: 100vh;
            overflow: visible;
        }

        body.operator-console.factory-orders-display-mode > .operator-app > .operator-workspace > div.flex-1 > main {
            flex: none;
            overflow: visible;
        }

        body.operator-console.factory-checking-display-mode > .operator-app,
        body.operator-console.factory-checking-display-mode > .operator-app > .operator-workspace,
        body.operator-console.factory-checking-display-mode > .operator-app > .operator-workspace > div.flex-1 {
            height: auto;
            min-height: 100vh;
            overflow: visible;
        }

        body.operator-console.factory-checking-display-mode > .operator-app > .operator-workspace > div.flex-1 > main {
            flex: none;
            overflow: visible;
        }

        body.operator-console.factory-reports-display-mode > .operator-app,
        body.operator-console.factory-reports-display-mode > .operator-app > .operator-workspace,
        body.operator-console.factory-reports-display-mode > .operator-app > .operator-workspace > div.flex-1 {
            height: auto;
            min-height: 100vh;
            overflow: visible;
        }

        body.operator-console.factory-reports-display-mode > .operator-app > .operator-workspace > div.flex-1 > main {
            flex: none;
            overflow: visible;
        }

        body.operator-console.production-display-mode > .operator-app,
        body.operator-console.production-display-mode > .operator-app > .operator-workspace,
        body.operator-console.production-display-mode > .operator-app > .operator-workspace > div.flex-1 {
            height: auto;
            min-height: 100vh;
            overflow: visible;
        }

        body.operator-console.production-display-mode > .operator-app > .operator-workspace > div.flex-1 > main {
            flex: none;
            overflow: visible;
        }

        body.operator-console.sales-display-mode > .operator-app,
        body.operator-console.sales-display-mode > .operator-app > .operator-workspace,
        body.operator-console.sales-display-mode > .operator-app > .operator-workspace > div.flex-1 {
            height: auto;
            min-height: 100vh;
            overflow: visible;
        }

        body.operator-console.sales-display-mode > .operator-app > .operator-workspace > div.flex-1 > main {
            flex: none;
            overflow: visible;
        }

        body.operator-console.bags-display-mode > .operator-app > .operator-workspace,
        body.operator-console.bags-display-mode > .operator-app > .operator-workspace > div.flex-1 {
            overflow: visible;
        }

        body.operator-console.bags-display-mode > .operator-app > .operator-workspace > div.flex-1 {
            height: auto;
            min-height: calc(100vh - 74px);
        }

        body.operator-console.bags-display-mode > .operator-app > .operator-workspace > div.flex-1 > main {
            flex: none;
            overflow: visible;
        }

        body.operator-console > .operator-app > .operator-titlebar,
        body.operator-console > .operator-app > .operator-menubar {
            position: sticky;
            z-index: 35;
        }

        .operator-titlebar {
            position: fixed !important;
            top: 0;
            left: 0;
            right: 0;
            z-index: 36 !important;
            flex: 0 0 auto;
            min-height: 43px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 7px 15px;
            color: #f8ffff;
            background: #153e43;
            border-bottom: 3px solid #74a49f;
        }

        .operator-titlebar-mark {
            width: 27px;
            height: 27px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #6c9b9d;
            color: #d6ff3a;
            font-size: 18px;
            font-weight: 800;
            border-radius: 2px;
        }

        .operator-titlebar-brand {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: .3px;
        }

        .operator-titlebar-subtitle {
            margin-left: 8px;
            opacity: .72;
            font-size: 11px;
        }

        .operator-titlebar-spacer { flex: 1; }

        .operator-user-meta {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 11px;
            white-space: nowrap;
        }

        .operator-user-initials {
            width: 27px;
            height: 27px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #153e43;
            background: #e5f6e7;
            border: 1px solid #b7d3c1;
            border-radius: 2px;
            font-weight: 800;
        }

        .operator-menubar {
            position: fixed !important;
            top: 43px;
            left: 0;
            right: 0;
            z-index: 35 !important;
            flex: 0 0 auto;
            min-height: 31px;
            display: flex;
            align-items: center;
            gap: 4px;
            overflow-x: auto;
            padding: 2px 11px;
            background: #f1f3f4;
            border-bottom: 1px solid #b7c1c7;
        }

        .operator-menubar a {
            flex: 0 0 auto;
            padding: 5px 11px;
            border: 1px solid transparent;
            border-radius: 2px;
            color: #34434a;
            font-size: 12px;
            text-decoration: none;
        }

        .operator-menubar a:hover,
        .operator-menubar a[aria-current="page"] {
            border-color: #9ca9af;
            background: #fff;
            color: #153e43;
        }

        .operator-mode-switch {
            display: inline-flex;
            flex: 0 0 auto;
            align-items: center;
            gap: 7px;
            margin-left: auto;
            padding-left: 10px;
            color: #526168;
            font-size: 11px;
            font-weight: 700;
        }

        .operator-mode-switch select {
            min-height: 28px;
            max-width: 180px;
            border: 1px solid #9daaaf;
            border-radius: 3px;
            background: #fff;
            padding: 3px 8px;
            color: #153e43;
            font-size: 11px;
            font-weight: 700;
        }

        .operator-toolbar-menu {
            display: none;
            min-width: 32px;
            height: 31px;
            align-items: center;
            justify-content: center;
            border: 1px solid #9daaaf;
            border-radius: 2px;
            background: #fff;
            color: #153e43;
        }

        .operator-bottom-actions {
            display: flex;
            flex: 0 0 auto;
            flex-wrap: wrap;
            align-items: center;
            gap: 7px;
            padding: 10px 20px;
            background: #f5f7f8;
            border-top: 1px solid #d4dee1;
        }

        .operator-bottom-actions-label {
            margin-right: 4px;
            color: #627079;
            font-size: 11px;
            font-weight: 700;
        }

        .operator-guide-overlay {
            position: fixed;
            inset: 0;
            z-index: 110;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgb(18 35 39 / 56%);
        }

        .operator-guide-overlay.is-open { display: flex; }

        .operator-guide-dialog {
            width: min(100%, 620px);
            max-height: min(82vh, 720px);
            overflow: auto;
            background: #fff;
            border: 1px solid #9eafb4;
            box-shadow: 0 16px 48px rgb(10 27 31 / 24%);
        }

        .operator-guide-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 13px 16px;
            color: #f8ffff;
            background: #153e43;
            border-bottom: 3px solid #74a49f;
        }

        .operator-guide-heading h2 { margin: 0; font-size: 16px; }

        .operator-guide-close {
            width: 30px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #6c9b9d;
            border-radius: 2px;
            background: transparent;
            color: #fff;
        }

        .operator-guide-body { padding: 16px; }

        .operator-guide-table { width: 100%; border-collapse: collapse; }

        .operator-guide-table th,
        .operator-guide-table td {
            padding: 9px 10px;
            border: 1px solid #d2dade;
            text-align: left;
            vertical-align: top;
        }

        .operator-guide-table th {
            background: #edf1f3;
            color: #45565d;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .operator-guide-table kbd {
            display: inline-block;
            padding: 2px 6px;
            border: 1px solid #b7c1c7;
            border-bottom-width: 2px;
            border-radius: 2px;
            background: #f7f9fa;
            color: #24333b;
            font: 600 11px Consolas, monospace;
            white-space: nowrap;
        }

        .operator-guide-note {
            margin-top: 12px;
            padding: 10px;
            background: #fbf9ee;
            border: 1px solid #e2d8af;
            color: #70633d;
            font-size: 11px;
            line-height: 1.5;
        }

        .operator-tool-link {
            min-height: 31px;
            display: inline-flex;
            align-items: center;
            padding: 6px 11px;
            border: 1px solid #9daaaf;
            border-radius: 2px;
            background: linear-gradient(#fff, #eff2f3);
            color: #2a383e;
            font-size: 11px;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
        }

        .operator-tool-link:hover {
            background: #fff;
            border-color: #71878d;
        }

        .operator-tool-link.primary {
            background: #0f6560;
            border-color: #0b5550;
            color: #fff;
        }

        .operator-bottom-actions .operator-tool-link[aria-current="page"] {
            background: #0f6560 !important;
            border-color: #0b5550 !important;
            color: #fff !important;
        }

        .operator-workspace {
            min-height: 0;
            flex: 1 1 auto;
            overflow: hidden;
        }

        body.operator-console #appSidebar {
            top: 74px !important;
            bottom: auto !important;
            height: calc(100vh - 74px) !important;
            max-height: calc(100vh - 74px) !important;
            align-self: flex-start;
        }

        body.operator-console.sizing-module-page #appSidebar,
        body.operator-console.parts-module-page #appSidebar,
        body.operator-console.fabric-module-page #appSidebar,
        body.operator-console.sales-module-page #appSidebar,
        body.operator-console.bags-module-page #appSidebar,
        body.operator-console.production-module-page #appSidebar,
        body.operator-console.factory-orders-page #appSidebar,
        body.operator-console.factory-checking-page #appSidebar,
        body.operator-console.factory-reports-page #appSidebar,
        body.operator-console.dashboard-page #appSidebar,
        body.operator-console.finance-module-page:not(.finance-display-mode) #appSidebar {
            top: 0 !important;
            height: 100% !important;
            max-height: 100% !important;
        }

        body.operator-console:not(.bags-display-mode):not(.sales-display-mode):not(.finance-display-mode):not(.ledger-report-page):not(.factory-orders-display-mode):not(.factory-checking-display-mode):not(.factory-reports-display-mode):not(.production-display-mode) > .operator-app > .operator-workspace > div.flex-1 {
            display: flex;
            flex-direction: column;
        }

        body.operator-console:not(.bags-display-mode):not(.sales-display-mode):not(.finance-display-mode):not(.ledger-report-page):not(.factory-orders-display-mode):not(.factory-checking-display-mode):not(.factory-reports-display-mode):not(.production-display-mode) > .operator-app > .operator-workspace > div.flex-1 > main {
            flex: 1 1 0%;
            min-height: 0;
            overflow-y: auto;
        }

        body.operator-console:not(.bags-display-mode):not(.sales-display-mode):not(.finance-display-mode):not(.ledger-report-page):not(.factory-orders-display-mode):not(.factory-checking-display-mode):not(.factory-reports-display-mode):not(.production-display-mode) > .operator-app > .operator-workspace > div.flex-1 > footer {
            flex: 0 0 auto;
        }

        @media (max-width: 1023px) {
            .operator-toolbar-menu { display: inline-flex; }
            body.operator-console #appSidebar {
                top: 0 !important;
                bottom: 0 !important;
                height: 100vh !important;
                max-height: 100vh !important;
            }
        }

        @media (max-width: 680px) {
            .operator-titlebar-subtitle,
            .operator-user-role { display: none; }
            .operator-user-meta { gap: 6px; }
            .operator-menubar { min-height: 31px; }
            .operator-tool-link { padding-right: 8px; padding-left: 8px; }
        }

        /* Refined light operator sidebar. */
        body.operator-console #appSidebar {
            background: #edf1f3 !important;
            border-right: 1px solid #b7c1c7 !important;
            box-shadow: 2px 0 8px rgb(36 51 59 / 4%) !important;
        }

        body.operator-console #appSidebar .sidebar-brand-header {
            min-height: 44px;
            justify-content: flex-end !important;
            padding: 6px 10px !important;
            background: #edf1f3 !important;
            border-bottom: 1px solid #c5cfd2 !important;
        }

        body.operator-console #appSidebar .sidebar-header-title {
            margin-right: auto;
            color: #54646a;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .09em;
            line-height: 1.2;
            text-transform: uppercase;
        }

        body.operator-console #appSidebar .sidebar-collapse-toggle {
            width: 30px !important;
            height: 30px !important;
            border: 1px solid #c5cfd2 !important;
            background: #f8fafb !important;
            color: #153e43 !important;
        }

        body.operator-console #appSidebar .sidebar-collapse-toggle:hover,
        body.operator-console #appSidebar .sidebar-collapse-toggle:focus-visible,
        body.operator-console #appSidebar .sidebar-brand-header > button:hover {
            border-color: #8eaaa9 !important;
            background: #dce9e8 !important;
            color: #153e43 !important;
        }

        body.operator-console #appSidebar .sidebar-brand-header > button {
            color: #153e43 !important;
        }

        body.operator-console #appSidebar .sidebar-nav {
            padding: 10px 9px !important;
        }

        body.operator-console #appSidebar .sidebar-nav > div {
            margin: 0 0 13px !important;
        }

        body.operator-console #appSidebar .sidebar-section-label {
            margin: 0 0 6px !important;
            padding: 7px 8px 6px !important;
            border-bottom: 1px solid #c5cfd2;
            color: #54646a !important;
            font-size: 10px !important;
            letter-spacing: .09em !important;
        }

        body.operator-console #appSidebar .sidebar-nav .space-y-1 > :not([hidden]) ~ :not([hidden]) {
            margin-top: 4px !important;
        }

        body.operator-console:not(.finance-display-mode) #appSidebar .sidebar-nav .space-y-1 > a.sidebar-finance-link {
            margin-top: 0 !important;
        }

        body.operator-console #appSidebar .sidebar-nav a {
            min-height: 37px;
            gap: 9px !important;
            padding: 6px 8px !important;
            border: 1px solid transparent !important;
            border-left-width: 3px !important;
            border-radius: 2px !important;
            color: #34434a !important;
            font-size: 12px !important;
            line-height: 1.25;
            box-shadow: none !important;
        }

        body.operator-console #appSidebar .sidebar-nav a:hover {
            border-color: #c5cfd2 !important;
            background: #fff !important;
            color: #153e43 !important;
        }

        body.operator-console #appSidebar .sidebar-nav a.shadow-md {
            border-color: #b4c9c7 !important;
            border-left-color: #0f625d !important;
            background: #dce9e8 !important;
            color: #153e43 !important;
            font-weight: 700 !important;
        }

        body.operator-console #appSidebar .sidebar-nav a svg {
            width: 19px !important;
            height: 19px !important;
            flex: 0 0 19px;
            padding: 2px;
            border: 1px solid #d2dcdf;
            border-radius: 2px;
            background: #f8fafb;
            color: #0f625d !important;
        }

        body.operator-console #appSidebar .sidebar-nav a.shadow-md svg {
            border-color: #9dbab6;
            background: #0f625d;
            color: #fff !important;
        }

        body.operator-console #appSidebar .sidebar-link-label {
            min-width: 0;
            flex: 1 1 auto;
        }

        body.operator-console #appSidebar .sidebar-shortcut-badge {
            margin-left: 0;
            padding: 2px 5px;
            border-color: #d3dcdf;
            background: #fff;
            color: #596a70;
            font-size: 9px;
            line-height: 1.2;
        }

        body.operator-console #appSidebar .sidebar-operator-panel {
            padding: 10px !important;
            background: #edf1f3 !important;
            border-top: 1px solid #c5cfd2 !important;
        }

        body.operator-console #appSidebar .sidebar-operator-card {
            padding: 10px !important;
            border: 1px solid #c5cfd2 !important;
            border-radius: 2px !important;
            background: #f8fafb !important;
            color: #34434a !important;
            box-shadow: none !important;
        }

        body.operator-console #appSidebar .sidebar-user-row {
            border-color: #d1dadd !important;
        }

        body.operator-console #appSidebar .sidebar-user-info > div:first-child {
            color: #24333b !important;
        }

        body.operator-console #appSidebar .sidebar-user-info > div:last-child {
            color: #0f625d !important;
        }

        body.operator-console #appSidebar .sidebar-logout-button {
            border: 1px solid #c5cfd2 !important;
            border-radius: 2px !important;
            background: #fff !important;
            color: #34434a !important;
        }

        body.operator-console #appSidebar .sidebar-logout-button:hover,
        body.operator-console #appSidebar .sidebar-logout-button:focus-visible {
            border-color: #8eaaa9 !important;
            background: #e4efee !important;
            color: #153e43 !important;
        }

        body.operator-console #appSidebar .custom-scrollbar::-webkit-scrollbar-track {
            background: #e5eaed;
        }

        body.operator-console #appSidebar .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #b6c2c7;
            border-radius: 2px;
        }

        @media (min-width: 1024px) {
            body.operator-console #appSidebar.sidebar-collapsed .sidebar-brand-header {
                justify-content: center !important;
                padding: 6px 8px !important;
            }

            body.operator-console #appSidebar.sidebar-collapsed .sidebar-header-title {
                display: none;
            }

            body.operator-console #appSidebar.sidebar-collapsed .sidebar-nav {
                padding-right: 7px !important;
                padding-left: 7px !important;
            }

            body.operator-console #appSidebar.sidebar-collapsed .sidebar-nav a {
                justify-content: center;
                padding-right: 5px !important;
                padding-left: 5px !important;
                border-left-width: 1px !important;
            }

            body.operator-console #appSidebar.sidebar-collapsed .sidebar-operator-panel {
                justify-content: center;
                padding: 8px 6px !important;
            }

            body.operator-console #appSidebar.sidebar-collapsed .sidebar-operator-card {
                padding: 4px 0 !important;
                border: 0 !important;
                background: transparent !important;
            }

            body.operator-console #appSidebar.sidebar-collapsed .sidebar-logout-button {
                width: 48px !important;
                min-width: 48px !important;
                max-width: 48px !important;
                height: 46px !important;
                border: 1px solid #c5cfd2 !important;
                border-radius: 2px !important;
                background: #fff !important;
                color: #34434a !important;
            }

            body.operator-console #appSidebar.sidebar-collapsed .sidebar-logout-icon,
            body.operator-console #appSidebar.sidebar-collapsed .sidebar-logout-label {
                color: #34434a !important;
            }
        }
    </style>
</head>
<body class="operator-console {{ request()->routeIs('dashboard', 'home') ? 'dashboard-page' : '' }} {{ request()->routeIs('bags.*') ? 'bags-module-page' : '' }} {{ request()->routeIs('sizing.*') ? 'sizing-module-page' : '' }} {{ request()->routeIs('parts.*') ? 'parts-module-page' : '' }} {{ request()->routeIs('fabric.*') ? 'fabric-module-page' : '' }} {{ request()->routeIs('sales.*') ? 'sales-module-page' : '' }} {{ request()->routeIs('production.*') ? 'production-module-page' : '' }} {{ request()->routeIs('invoices.*', 'accounts.*', 'expenses.*') ? 'finance-module-page' : '' }} {{ request()->routeIs('factory.orders') ? 'factory-orders-page' : '' }} {{ request()->routeIs('factory.checking') ? 'factory-checking-page' : '' }} {{ request()->routeIs('factory.reports') ? 'factory-reports-page' : '' }} {{ request()->routeIs('bags.*') && request()->query('mode') === 'display' ? 'bags-display-mode' : '' }} {{ request()->routeIs('sizing.*') && request()->query('mode') === 'display' ? 'sizing-display-mode' : '' }} {{ request()->routeIs('parts.*') && request()->query('mode') === 'display' ? 'parts-display-mode' : '' }} {{ request()->routeIs('fabric.*') && request()->query('mode') === 'display' ? 'fabric-display-mode' : '' }} {{ request()->routeIs('sales.*') && request()->query('mode') === 'display' ? 'sales-display-mode' : '' }} {{ request()->routeIs('invoices.*', 'accounts.*', 'expenses.*') && request()->query('mode') === 'display' ? 'finance-display-mode' : '' }} {{ request()->routeIs('ledgers.*') ? 'ledger-report-page' : '' }} {{ request()->routeIs('factory.orders') && request()->query('mode') === 'display' ? 'factory-orders-display-mode' : '' }} {{ request()->routeIs('factory.checking') && request()->query('mode') === 'display' ? 'factory-checking-display-mode' : '' }} {{ request()->routeIs('factory.reports') && request()->query('mode') === 'display' ? 'factory-reports-display-mode' : '' }} {{ request()->routeIs('production.*') && request()->query('mode') === 'display' ? 'production-display-mode' : '' }} h-full antialiased bg-[#f4f6f4] text-[#131e18]">
    <div class="operator-app">
        <div class="operator-titlebar">
            <span class="operator-titlebar-mark" aria-hidden="true">L</span>
            <div><span class="operator-titlebar-brand">LoomFlow</span><span class="operator-titlebar-subtitle">Grey Fabric Weaving Management System</span></div>
            <span class="operator-titlebar-spacer"></span>
            @auth
                <div class="operator-user-meta" title="{{ Auth::user()->name }}">
                    <span class="operator-user-role">Factory Console &nbsp; | &nbsp; {{ Auth::user()->name }} &nbsp; | &nbsp; {{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}</span>
                    <span class="operator-user-initials">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
                </div>
            @else
                <a class="operator-tool-link primary" href="{{ route('login') }}">Sign in</a>
            @endauth
        </div>
        
        @php
            $currentRoute = Route::currentRouteName() ?? '';
            $hasOperatorCtrlOneShortcut = match (true) {
                $currentRoute === 'factory.orders' => true,
                $currentRoute === 'factory.checking' => true,
                $currentRoute === 'factory.reports' => true,
                $currentRoute === 'bags.index' => request()->query('mode', 'operator') === 'operator',
                $currentRoute === 'sizing.index' => request()->query('mode', 'operator') === 'operator',
                $currentRoute === 'parts.index' => request()->query('mode', 'operator') === 'operator',
                $currentRoute === 'fabric.index' => request()->query('mode', 'operator') === 'operator',
                $currentRoute === 'sales.index' => request()->query('mode', 'operator') === 'operator',
                $currentRoute === 'invoices.invoices' => request()->query('mode', 'operator') === 'operator',
                $currentRoute === 'production.index' => request()->query('mode', 'operator') === 'operator',
                default => false,
            };
            $operatorCtrlOneAction = match ($currentRoute) {
                'factory.orders' => request()->query('entry') === 'order' ? 'Open Create Production Order' : 'Open Save Quality Parta',
                'factory.checking' => 'Focus the checking entry form',
                'factory.reports' => 'Focus Loom Downtime / Maintenance',
                'bags.index' => 'Open Bag Purchase',
                'sizing.index' => 'Open New Sizing Slip Entry',
                'parts.index' => 'Open Add New Part',
                'fabric.index' => 'Open Fabric Stock Entry',
                'sales.index' => 'Open the first Sales entry form',
                'invoices.invoices' => 'Open Create Invoice',
                'production.index' => 'Focus Record Loom Production',
                default => '',
            };
            
            // Breadcrumb detection matching previous module names
            $pageTitle = 'Main Hub / Boxes';
            if (str_starts_with($currentRoute, 'factory.orders')) {
                $pageTitle = 'Factory Orders & Parta';
            } elseif (str_starts_with($currentRoute, 'factory.checking')) {
                $pageTitle = 'Checking / Thaan Stock';
            } elseif (str_starts_with($currentRoute, 'factory.reports')) {
                $pageTitle = 'Factory Reports';
            } elseif (str_starts_with($currentRoute, 'production')) {
                $pageTitle = '6. Production';
            } elseif (str_starts_with($currentRoute, 'sizing')) {
                $pageTitle = '2. Sizing & Beams';
            } elseif (str_starts_with($currentRoute, 'bags')) {
                $pageTitle = '1. Bags (Yarn)';
            } elseif (str_starts_with($currentRoute, 'parts')) {
                $pageTitle = '3. Parts Store';
            } elseif (str_starts_with($currentRoute, 'fabric')) {
                $pageTitle = '4. Fabric Stock';
            } elseif (str_starts_with($currentRoute, 'sales')) {
                $pageTitle = '5. Sales & Slips';
            } elseif (str_starts_with($currentRoute, 'invoices')) {
                $pageTitle = '7. Invoices & Accounts';
            } elseif (str_starts_with($currentRoute, 'accounts')) {
                $pageTitle = 'Accounts Overview';
            } elseif (str_starts_with($currentRoute, 'ledgers')) {
                $pageTitle = 'Party Ledgers';
            } elseif (str_starts_with($currentRoute, 'expenses')) {
                $pageTitle = '8. Expenses';
            }
            $pageHeading = preg_replace('/^\d+\.\s*/', '', $pageTitle);
        @endphp

        <nav class="operator-menubar" aria-label="Primary navigation">
            <button class="operator-toolbar-menu" type="button" onclick="toggleSidebar()" aria-label="Open navigation menu">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <a href="{{ route('dashboard') }}" @if(in_array($currentRoute, ['dashboard', 'home'])) aria-current="page" @endif>Home</a>
            <a href="{{ route('factory.orders') }}" @if(str_starts_with($currentRoute, 'factory.')) aria-current="page" @endif>Factory</a>
            <a href="{{ route('production.index') }}" @if(str_starts_with($currentRoute, 'production')) aria-current="page" @endif>Production</a>
            <a href="{{ route('bags.index') }}" @if(in_array($currentRoute, ['bags.index', 'sizing.index', 'parts.index', 'fabric.index'])) aria-current="page" @endif>Store &amp; Stock</a>
            <a href="{{ route('sales.index') }}" @if(str_starts_with($currentRoute, 'sales')) aria-current="page" @endif>Sales</a>
            <a href="{{ route('invoices.index') }}" @if(str_starts_with($currentRoute, 'invoices') || str_starts_with($currentRoute, 'accounts') || str_starts_with($currentRoute, 'ledgers') || str_starts_with($currentRoute, 'expenses')) aria-current="page" @endif>Accounts</a>
            <a href="{{ route('factory.reports') }}" @if(str_starts_with($currentRoute, 'factory.reports')) aria-current="page" @endif>Reports</a>
            @if(str_starts_with($currentRoute, 'production'))
                <form method="GET" action="{{ request()->url() }}" class="operator-mode-switch">
                    <label for="production-mode-switch">Production view</label>
                    <select id="production-mode-switch" name="mode" onchange="this.form.submit()">
                        <option value="operator" @selected(request()->query('mode', 'operator') === 'operator')>Operator</option>
                        <option value="display" @selected(request()->query('mode', 'operator') === 'display')>LoomFlow Display</option>
                    </select>
                </form>
            @elseif($currentRoute === 'factory.orders')
                <form method="GET" action="{{ route('factory.orders') }}" class="operator-mode-switch">
                    <label for="factory-orders-mode-switch">Factory Orders view</label>
                    <select id="factory-orders-mode-switch" name="mode" onchange="this.form.submit()">
                        <option value="operator" @selected(request()->query('mode', 'operator') === 'operator')>Operator</option>
                        <option value="display" @selected(request()->query('mode', 'operator') === 'display')>LoomFlow Display</option>
                    </select>
                </form>
            @elseif($currentRoute === 'factory.checking')
                <form method="GET" action="{{ route('factory.checking') }}" class="operator-mode-switch">
                    <label for="factory-checking-mode-switch">Factory Checking view</label>
                    <select id="factory-checking-mode-switch" name="mode" onchange="this.form.submit()">
                        <option value="operator" @selected(request()->query('mode', 'operator') === 'operator')>Operator</option>
                        <option value="display" @selected(request()->query('mode', 'operator') === 'display')>LoomFlow Display</option>
                    </select>
                </form>
            @elseif($currentRoute === 'factory.reports')
                <form method="GET" action="{{ route('factory.reports') }}" class="operator-mode-switch">
                    <label for="factory-reports-mode-switch">Factory Reports view</label>
                    <select id="factory-reports-mode-switch" name="mode" onchange="this.form.submit()">
                        <option value="operator" @selected(request()->query('mode', 'operator') === 'operator')>Operator</option>
                        <option value="display" @selected(request()->query('mode', 'operator') === 'display')>LoomFlow Display</option>
                    </select>
                </form>
            @elseif(str_starts_with($currentRoute, 'bags.'))
                <form method="GET" action="{{ request()->url() }}" class="operator-mode-switch">
                    <label for="bags-mode-switch">Bags view</label>
                    <select id="bags-mode-switch" name="mode" onchange="this.form.submit()">
                        <option value="operator" @selected(($mode ?? 'operator') === 'operator')>Operator</option>
                        <option value="display" @selected(($mode ?? 'operator') === 'display')>LoomFlow Display</option>
                    </select>
                </form>
            @elseif(str_starts_with($currentRoute, 'sizing'))
                <form method="GET" action="{{ request()->url() }}" class="operator-mode-switch">
                    <label for="sizing-mode-switch">Sizing view</label>
                    <select id="sizing-mode-switch" name="mode" onchange="this.form.submit()">
                        <option value="operator" @selected(request()->query('mode', 'operator') === 'operator')>Operator</option>
                        <option value="display" @selected(request()->query('mode', 'operator') === 'display')>LoomFlow Display</option>
                    </select>
                </form>
            @elseif(str_starts_with($currentRoute, 'parts'))
                <form method="GET" action="{{ request()->url() }}" class="operator-mode-switch">
                    <label for="parts-mode-switch">Parts view</label>
                    <select id="parts-mode-switch" name="mode" onchange="this.form.submit()">
                        <option value="operator" @selected(request()->query('mode', 'operator') === 'operator')>Operator</option>
                        <option value="display" @selected(request()->query('mode', 'operator') === 'display')>LoomFlow Display</option>
                    </select>
                </form>
            @elseif(str_starts_with($currentRoute, 'fabric'))
                <form method="GET" action="{{ request()->url() }}" class="operator-mode-switch">
                    <label for="fabric-mode-switch">Fabric view</label>
                    <select id="fabric-mode-switch" name="mode" onchange="this.form.submit()">
                        <option value="operator" @selected(request()->query('mode', 'operator') === 'operator')>Operator</option>
                        <option value="display" @selected(request()->query('mode', 'operator') === 'display')>LoomFlow Display</option>
                    </select>
                </form>
            @elseif(str_starts_with($currentRoute, 'sales'))
                <form method="GET" action="{{ request()->url() }}" class="operator-mode-switch">
                    <label for="sales-mode-switch">Sales view</label>
                    <select id="sales-mode-switch" name="mode" onchange="this.form.submit()">
                        <option value="operator" @selected(request()->query('mode', 'operator') === 'operator')>Operator</option>
                        <option value="display" @selected(request()->query('mode', 'operator') === 'display')>LoomFlow Display</option>
                    </select>
                </form>
            @elseif(str_starts_with($currentRoute, 'invoices') || str_starts_with($currentRoute, 'accounts') || str_starts_with($currentRoute, 'expenses'))
                <form method="GET" action="{{ request()->url() }}" class="operator-mode-switch">
                    <label for="finance-mode-switch">Finance view</label>
                    <select id="finance-mode-switch" name="mode" onchange="this.form.submit()">
                        <option value="operator" @selected(request()->query('mode', 'operator') === 'operator')>Operator</option>
                        <option value="display" @selected(request()->query('mode', 'operator') === 'display')>LoomFlow Display</option>
                    </select>
                </form>
            @endif
        </nav>

        <!-- BACKDROP FOR MOBILE SIDEBAR -->
        <div id="sidebarBackdrop" onclick="toggleSidebar()" class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm hidden lg:hidden transition-opacity"></div>
        <div id="sidebarTooltip" class="pointer-events-none fixed z-[100] hidden max-w-[16rem] rounded-xl border border-[#205c41] bg-[#0f3323] px-3 py-2 text-xs font-bold text-white shadow-xl" role="tooltip"></div>

        <!-- LEFT SIDEBAR: FIXED HEIGHT (lg:sticky lg:top-0 lg:h-screen lg:max-h-screen), SLIGHTLY DARKER GREEN (#0f3323) -->
        <div class="operator-workspace flex min-h-0 flex-1">
        <aside id="appSidebar" class="fixed inset-y-0 left-0 z-50 w-64 lg:sticky lg:top-0 lg:h-screen lg:max-h-screen bg-[#0f3323] text-white flex flex-col justify-between transition-all duration-300 ease-in-out -translate-x-full lg:translate-x-0 shrink-0 select-none border-r border-[#1a4d36] shadow-xl">
            
            <!-- Top Brand Header (Fixed at top of sidebar) -->
            <div class="sidebar-brand-header px-5 py-4 flex items-center justify-between border-b border-[#1a4d36] shrink-0 bg-[#0f3323]">
                <span class="sidebar-header-title">Factory Operations</span>
                <button type="button" onclick="toggleSidebar()" class="lg:hidden p-1.5 rounded-lg text-white hover:bg-[#1a4d36]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <button type="button" onclick="toggleDesktopSidebar(event)" class="sidebar-collapse-toggle hidden lg:flex h-8 w-8 items-center justify-center rounded-lg text-white transition-colors hover:bg-[#1a4d36]" aria-label="Collapse sidebar" aria-expanded="true" title="Collapse sidebar" data-sidebar-label="Collapse sidebar">
                    <svg class="sidebar-toggle-icon h-4 w-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
            </div>

            <!-- Navigation List (Scrolls independently within fixed sidebar height - NO DROPDOWNS) -->
            <nav class="sidebar-nav px-3 py-3 space-y-5 overflow-y-auto custom-scrollbar flex-1">
                
                <!-- Section 1: Factory operations -->
                <div>
                    <div class="space-y-1">
                        <!-- Main Hub / Boxes -->
                        <a href="{{ route('dashboard') }}" data-sidebar-label="Main Hub / Boxes" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ in_array($currentRoute, ['dashboard', 'home']) ? 'bg-[#184c35] text-white shadow-md border-2 border-[#c6f16d] font-bold' : 'text-white hover:bg-[#15422e] hover:text-white border-2 border-transparent' }}">
                            <svg class="w-4 h-4 shrink-0 {{ in_array($currentRoute, ['dashboard', 'home']) ? 'text-[#c6f16d]' : 'text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span class="sidebar-link-label truncate">Main Hub / Boxes</span>
                        </a>

                        <!-- Factory Orders & Parta -->
                        <a href="{{ route('factory.orders') }}" data-sidebar-label="Factory Orders &amp; Parta" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_starts_with($currentRoute, 'factory.orders') ? 'bg-[#184c35] text-white shadow-md border-2 border-[#c6f16d] font-bold' : 'text-white hover:bg-[#15422e] hover:text-white border-2 border-transparent' }}">
                            <svg class="w-4 h-4 shrink-0 {{ str_starts_with($currentRoute, 'factory.orders') ? 'text-[#c6f16d]' : 'text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span class="sidebar-link-label truncate">Factory Orders &amp; Parta</span>
                        </a>

                        <!-- Checking / Thaan Stock -->
                        <a href="{{ route('factory.checking') }}" data-sidebar-label="Checking / Thaan Stock" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_starts_with($currentRoute, 'factory.checking') ? 'bg-[#184c35] text-white shadow-md border-2 border-[#c6f16d] font-bold' : 'text-white hover:bg-[#15422e] hover:text-white border-2 border-transparent' }}">
                            <svg class="w-4 h-4 shrink-0 {{ str_starts_with($currentRoute, 'factory.checking') ? 'text-[#c6f16d]' : 'text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                            <span class="sidebar-link-label truncate">Checking / Thaan Stock</span>
                        </a>

                        <!-- Sales Contracts -->
                        <a href="{{ route('sales.contracts') }}" data-sidebar-label="Sales Contracts" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_starts_with($currentRoute, 'sales.contracts') ? 'bg-[#184c35] text-white shadow-md border-2 border-[#c6f16d] font-bold' : 'text-white hover:bg-[#15422e] hover:text-white border-2 border-transparent' }}">
                            <svg class="w-4 h-4 shrink-0 {{ str_starts_with($currentRoute, 'sales.contracts') ? 'text-[#c6f16d]' : 'text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a2 2 0 01.707.293l4.414 4.414A2 2 0 0120 9.121V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                            </svg>
                            <span class="sidebar-link-label truncate">Sales Contracts</span>
                        </a>

                        <!-- 6. Production -->
                        <a href="{{ route('production.index') }}" data-sidebar-label="6. Production" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_starts_with($currentRoute, 'production') ? 'bg-[#184c35] text-white shadow-md border-2 border-[#c6f16d] font-bold' : 'text-white hover:bg-[#15422e] hover:text-white border-2 border-transparent' }}">
                            <svg class="w-4 h-4 shrink-0 {{ str_starts_with($currentRoute, 'production') ? 'text-[#c6f16d]' : 'text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <span class="sidebar-link-label truncate">6. Production</span>
                        </a>

                        <!-- Factory Reports -->
                        <a href="{{ route('factory.reports') }}" data-sidebar-label="Factory Reports" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_starts_with($currentRoute, 'factory.reports') ? 'bg-[#184c35] text-white shadow-md border-2 border-[#c6f16d] font-bold' : 'text-white hover:bg-[#15422e] hover:text-white border-2 border-transparent' }}">
                            <svg class="w-4 h-4 shrink-0 {{ str_starts_with($currentRoute, 'factory.reports') ? 'text-[#c6f16d]' : 'text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <span class="sidebar-link-label truncate">Factory Reports</span>
                        </a>
                    </div>
                </div>

                <!-- Section 2: STORE & ACCOUNTS -->
                <div>
                    <div class="sidebar-section-label px-3 mb-2 text-[11px] font-black uppercase tracking-wider text-white">
                        Store &amp; Accounts
                    </div>
                    <div class="space-y-1">
                        <!-- 1. Bags (Yarn) -->
                        <a href="{{ route('bags.index') }}" data-sidebar-label="1. Bags (Yarn)" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_starts_with($currentRoute, 'bags') ? 'bg-[#184c35] text-white shadow-md border-2 border-[#c6f16d] font-bold' : 'text-white hover:bg-[#15422e] hover:text-white border-2 border-transparent' }}">
                            <svg class="w-4 h-4 shrink-0 {{ str_starts_with($currentRoute, 'bags') ? 'text-[#c6f16d]' : 'text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <span class="sidebar-link-label truncate">1. Bags (Yarn)</span>
                        </a>

                        <!-- 2. Sizing & Beams -->
                        <a href="{{ route('sizing.index') }}" data-sidebar-label="2. Sizing &amp; Beams" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_starts_with($currentRoute, 'sizing') ? 'bg-[#184c35] text-white shadow-md border-2 border-[#c6f16d] font-bold' : 'text-white hover:bg-[#15422e] hover:text-white border-2 border-transparent' }}">
                            <svg class="w-4 h-4 shrink-0 {{ str_starts_with($currentRoute, 'sizing') ? 'text-[#c6f16d]' : 'text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            <span class="sidebar-link-label truncate">2. Sizing &amp; Beams</span>
                        </a>

                        <!-- 3. Parts Store -->
                        <a href="{{ route('parts.index') }}" data-sidebar-label="3. Parts Store" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_starts_with($currentRoute, 'parts') ? 'bg-[#184c35] text-white shadow-md border-2 border-[#c6f16d] font-bold' : 'text-white hover:bg-[#15422e] hover:text-white border-2 border-transparent' }}">
                            <svg class="w-4 h-4 shrink-0 {{ str_starts_with($currentRoute, 'parts') ? 'text-[#c6f16d]' : 'text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            </svg>
                            <span class="sidebar-link-label truncate">3. Parts Store</span>
                        </a>

                        <!-- 4. Fabric Stock -->
                        <a href="{{ route('fabric.index') }}" data-sidebar-label="4. Fabric Stock" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_starts_with($currentRoute, 'fabric') ? 'bg-[#184c35] text-white shadow-md border-2 border-[#c6f16d] font-bold' : 'text-white hover:bg-[#15422e] hover:text-white border-2 border-transparent' }}">
                            <svg class="w-4 h-4 shrink-0 {{ str_starts_with($currentRoute, 'fabric') ? 'text-[#c6f16d]' : 'text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                            </svg>
                            <span class="sidebar-link-label truncate">4. Fabric Stock</span>
                        </a>

                        <!-- 5. Sales & Slips -->
                        <a href="{{ route('sales.index') }}" data-sidebar-label="5. Sales &amp; Slips" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_starts_with($currentRoute, 'sales') ? 'bg-[#184c35] text-white shadow-md border-2 border-[#c6f16d] font-bold' : 'text-white hover:bg-[#15422e] hover:text-white border-2 border-transparent' }}">
                            <svg class="w-4 h-4 shrink-0 {{ str_starts_with($currentRoute, 'sales') ? 'text-[#c6f16d]' : 'text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span class="sidebar-link-label truncate">5. Sales &amp; Slips</span>
                        </a>

                        <!-- 7. Invoices & Accounts -->
                        <a href="{{ route('invoices.index') }}" data-sidebar-label="7. Invoices &amp; Accounts" class="sidebar-finance-link flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_starts_with($currentRoute, 'invoices') ? 'bg-[#184c35] text-white shadow-md border-2 border-[#c6f16d] font-bold' : 'text-white hover:bg-[#15422e] hover:text-white border-2 border-transparent' }}">
                            <svg class="w-4 h-4 shrink-0 {{ str_starts_with($currentRoute, 'invoices') ? 'text-[#c6f16d]' : 'text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span class="sidebar-link-label truncate">7. Invoices &amp; Accounts</span>
                        </a>

                        <a href="{{ route('accounts.index') }}" data-sidebar-label="Accounts Overview" class="sidebar-finance-link flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_starts_with($currentRoute, 'accounts') ? 'bg-[#184c35] text-white shadow-md border-2 border-[#c6f16d] font-bold' : 'text-white hover:bg-[#15422e] hover:text-white border-2 border-transparent' }}">
                            <svg class="w-4 h-4 shrink-0 {{ str_starts_with($currentRoute, 'accounts') ? 'text-[#c6f16d]' : 'text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h2m4 0h2m-9 5h12a3 3 0 003-3V7a3 3 0 00-3-3H6a3 3 0 00-3 3v10a3 3 0 003 3z"/>
                            </svg>
                            <span class="sidebar-link-label truncate">Accounts Overview</span>
                        </a>

                        <!-- 8. Expenses -->
                        <a href="{{ route('expenses.index') }}" data-sidebar-label="8. Expenses" class="sidebar-finance-link flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_starts_with($currentRoute, 'expenses') ? 'bg-[#184c35] text-white shadow-md border-2 border-[#c6f16d] font-bold' : 'text-white hover:bg-[#15422e] hover:text-white border-2 border-transparent' }}">
                            <svg class="w-4 h-4 shrink-0 {{ str_starts_with($currentRoute, 'expenses') ? 'text-[#c6f16d]' : 'text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                            </svg>
                            <span class="sidebar-link-label truncate">8. Expenses</span>
                        </a>

                        <!-- Party Ledgers -->
                        <a href="{{ route('ledgers.index') }}" data-sidebar-label="Party Ledgers" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_starts_with($currentRoute, 'ledgers') ? 'bg-[#184c35] text-white shadow-md border-2 border-[#c6f16d] font-bold' : 'text-white hover:bg-[#15422e] hover:text-white border-2 border-transparent' }}">
                            <svg class="w-4 h-4 shrink-0 {{ str_starts_with($currentRoute, 'ledgers') ? 'text-[#c6f16d]' : 'text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="sidebar-link-label truncate">Party Ledgers</span>
                        </a>
                    </div>
                </div>

            </nav>

            <!-- Bottom Operator & User Panel (Fixed at bottom of sidebar) -->
            <div class="sidebar-operator-panel p-3 shrink-0 border-t border-[#1a4d36] bg-[#0f3323]">
                <div class="sidebar-operator-card p-3 rounded-2xl bg-[#143d2b] border border-[#20583e] text-xs">
                    <div class="sidebar-operator-copy text-[10px] font-extrabold uppercase tracking-[0.12em] text-[#627079]">Signed in</div>

                    @auth
                        <div class="sidebar-user-row flex items-center justify-between mt-2.5 pt-2.5 border-t border-[#20583e]">
                            <div class="sidebar-user-info truncate mr-2">
                                <div class="text-xs font-black text-white truncate">{{ Auth::user()->name }}</div>
                                <div class="text-[9px] text-[#c6f16d] uppercase tracking-wider font-extrabold">{{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}</div>
                            </div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="sidebar-logout-button relative flex items-center gap-2 p-1.5 rounded-lg text-white hover:text-[#c6f16d] hover:bg-[#184c35] transition-colors" title="Sign out" aria-label="Sign out" data-sidebar-label="Sign out">
                                    <svg class="sidebar-logout-icon w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    <span class="sidebar-logout-label">Sign out</span>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="mt-2.5 pt-2.5 border-t border-[#20583e]">
                            <a href="{{ route('login') }}" class="block text-center py-1.5 px-3 rounded-lg bg-[#c6f16d] text-[#0f3323] font-black text-xs hover:bg-[#b5e759] transition-all">Sign In</a>
                        </div>
                    @endauth
                </div>
            </div>
        </aside>

        @yield('workspace_sidebar')

        <!-- MAIN VIEWPORT CONTAINER (Scrolls independently) -->
        <div class="flex-1 flex flex-col min-w-0 min-h-screen">

            <!-- FLASH NOTIFICATIONS -->
            <div class="px-4 sm:px-8 mt-4">
                @if(session('success'))
                    <div class="p-4 rounded-2xl bg-[#133e2b] text-white border border-[#205c41] flex items-start gap-3 shadow-sm">
                        <div class="w-6 h-6 rounded-full bg-[#c6f16d] text-[#133e2b] flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">✓</div>
                        <div class="text-sm font-medium">{{ session('success') }}</div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 flex items-start gap-3 shadow-sm">
                        <svg class="w-5 h-5 text-rose-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="text-sm font-medium">{{ session('error') }}</div>
                    </div>
                @endif

                @if(session('info'))
                    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-start gap-3 shadow-sm">
                        <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="text-sm font-medium">{{ session('info') }}</div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 shadow-sm">
                        <div class="flex items-center gap-2 font-bold text-sm mb-1">
                            <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            <span>Please correct the following:</span>
                        </div>
                        <ul class="list-disc list-inside text-xs space-y-1">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- MAIN BODY CONTENT -->
            @php
                $isCheckingQuickLink = request()->routeIs('factory.checking', 'factory.checking.*');
                $isParchiQuickLink = request()->routeIs('factory.parchis', 'factory.kachi.*', 'factory.pakki.*', 'factory.returns.*');
                $isSalesContractsQuickLink = request()->routeIs('sales.contracts', 'sales.contracts.*');
                $isPartyAccountsQuickLink = request()->routeIs('accounts.*');
            @endphp
            <nav class="operator-bottom-actions" aria-label="Common destinations">
                <span class="operator-bottom-actions-label">Quick access</span>
                <a class="operator-tool-link {{ $isCheckingQuickLink ? 'primary' : '' }}" href="{{ route('factory.checking') }}" @if($isCheckingQuickLink) aria-current="page" @endif>Checking Entry</a>
                <a class="operator-tool-link {{ $isParchiQuickLink ? 'primary' : '' }}" href="{{ route('factory.parchis') }}" @if($isParchiQuickLink) aria-current="page" @endif>Kachi / Pakki Parchis</a>
                <a class="operator-tool-link {{ $isSalesContractsQuickLink ? 'primary' : '' }}" href="{{ route('sales.contracts') }}" @if($isSalesContractsQuickLink) aria-current="page" @endif>Sales Contracts</a>
                <a class="operator-tool-link {{ $isPartyAccountsQuickLink ? 'primary' : '' }}" href="{{ route('accounts.index') }}" @if($isPartyAccountsQuickLink) aria-current="page" @endif>Party Accounts</a>
                <button class="operator-tool-link" type="button" onclick="openOperatorKeyboardGuide()">Keyboard Guide · Shift ×3</button>
            </nav>

            <main class="min-h-0 flex-1 overflow-y-auto overscroll-contain px-4 py-6 sm:px-8">
                @yield('content')
            </main>

            <!-- SUBTLE BOTTOM NOTE -->
            <footer class="mt-auto shrink-0 px-4 sm:px-8 py-6 text-center text-xs text-stone-400 border-t border-[#e2e8e0]">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-2">
                    <div>
                        <strong class="text-stone-700">LoomFlow</strong> &copy; {{ date('Y') }} &middot; Grey Fabric Weaving Mill Operations
                    </div>
                    <div class="text-[11px] text-stone-500">
                        INTERACTIVE UI PROTOTYPE &middot; Production &amp; Weaving Engine
                    </div>
                </div>
            </footer>

        </div>
        </div>

    </div>

    <div id="operatorKeyboardGuide" class="operator-guide-overlay" onclick="if (event.target === this) closeOperatorKeyboardGuide()">
        <section class="operator-guide-dialog" role="dialog" aria-modal="true" aria-labelledby="operatorKeyboardGuideTitle" tabindex="-1">
            <div class="operator-guide-heading">
                <h2 id="operatorKeyboardGuideTitle">Keyboard Shortcuts</h2>
                <button class="operator-guide-close" type="button" onclick="closeOperatorKeyboardGuide()" aria-label="Close keyboard shortcuts">×</button>
            </div>
            <div class="operator-guide-body">
                <table class="operator-guide-table">
                    <thead><tr><th>Keys</th><th>Action</th></tr></thead>
                    <tbody>
                        @if(request()->routeIs('factory.orders', 'factory.checking', 'factory.reports', 'bags.*', 'sizing.*', 'parts.*', 'fabric.*', 'sales.*', 'invoices.*', 'accounts.*', 'expenses.*', 'production.*'))
                        <tr><td><kbd>Ctrl</kbd> + <kbd>Q</kbd></td><td>Switch between Operator and LoomFlow Display</td></tr>
                        @endif
                        @if($hasOperatorCtrlOneShortcut)
                        <tr><td><kbd>Ctrl</kbd> + <kbd>1</kbd></td><td>{{ $operatorCtrlOneAction }}</td></tr>
                        @endif
                        <tr><td><kbd>Alt</kbd> + <kbd>1</kbd></td><td>Open Checking / Thaan Entry</td></tr>
                        <tr><td><kbd>Alt</kbd> + <kbd>2</kbd></td><td>Open Production</td></tr>
                        <tr><td><kbd>Alt</kbd> + <kbd>3</kbd></td><td>Open Kachi / Pakki Parchis</td></tr>
                        <tr><td><kbd>Alt</kbd> + <kbd>4</kbd></td><td>Open Pakki acceptance in Kachi / Pakki Parchis</td></tr>
                        <tr><td><kbd>Alt</kbd> + <kbd>5</kbd></td><td>Open Bags and Yarn</td></tr>
                        <tr><td><kbd>Alt</kbd> + <kbd>6</kbd></td><td>Open Receipts and Payments</td></tr>
                        <tr><th colspan="2">Sidebar destinations — in sidebar order</th></tr>
                        <tr><td><kbd>Shift</kbd> + <kbd>1</kbd></td><td>Main Hub / Boxes</td></tr>
                        <tr><td><kbd>Shift</kbd> + <kbd>2</kbd></td><td>Factory Orders &amp; Parta</td></tr>
                        <tr><td><kbd>Shift</kbd> + <kbd>3</kbd></td><td>Checking / Thaan Stock</td></tr>
                        <tr><td><kbd>Shift</kbd> + <kbd>4</kbd></td><td>Sales Contracts</td></tr>
                        <tr><td><kbd>Shift</kbd> + <kbd>5</kbd></td><td>Production</td></tr>
                        <tr><td><kbd>Shift</kbd> + <kbd>6</kbd></td><td>Factory Reports</td></tr>
                        <tr><td><kbd>Shift</kbd> + <kbd>7</kbd></td><td>Bags (Yarn)</td></tr>
                        <tr><td><kbd>Shift</kbd> + <kbd>8</kbd></td><td>Sizing &amp; Beams</td></tr>
                        <tr><td><kbd>Shift</kbd> + <kbd>9</kbd></td><td>Parts Store</td></tr>
                        <tr><td><kbd>Shift</kbd> + <kbd>0</kbd></td><td>Fabric Stock</td></tr>
                        <tr><td><kbd>Shift</kbd> + <kbd>Q</kbd></td><td>Sales &amp; Slips</td></tr>
                        <tr><td><kbd>Shift</kbd> + <kbd>W</kbd></td><td>Invoices &amp; Accounts</td></tr>
                        <tr><td><kbd>Shift</kbd> + <kbd>E</kbd></td><td>Accounts Overview</td></tr>
                        <tr><td><kbd>Shift</kbd> + <kbd>R</kbd></td><td>Expenses</td></tr>
                        <tr><td><kbd>Shift</kbd> + <kbd>T</kbd></td><td>Party Ledgers</td></tr>
                        <tr><td><kbd>Shift</kbd> + <kbd>Y</kbd></td><td>Collapse or expand the sidebar</td></tr>
                        <tr><td><kbd>F2</kbd></td><td>Focus the first editable field; opens Checking if the page has no entry fields</td></tr>
                        <tr><td><kbd>F8</kbd></td><td>Submit the current form when focus is in one of its fields</td></tr>
                        <tr><td><kbd>Enter</kbd></td><td>Move to the next editable cell in a table</td></tr>
                        <tr><td><kbd>Tab</kbd></td><td>Move to the next field using normal browser focus order</td></tr>
                        <tr><td><kbd>Esc</kbd></td><td>Close this guide, or return to the dashboard when not editing a field</td></tr>
                    </tbody>
                </table>
                <p class="operator-guide-note">Open this guide by pressing <kbd>Shift</kbd> three times quickly, or use the Keyboard Guide button below the notices. Navigation shortcuts are paused while typing in a field.</p>
            </div>
        </section>
    </div>

    <!-- Scripts and Modal Helpers -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('appSidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            if (sidebar) {
                sidebar.classList.toggle('-translate-x-full');
            }
            if (backdrop) {
                backdrop.classList.toggle('hidden');
            }
        }

        const sidebar = document.getElementById('appSidebar');
        const sidebarTooltip = document.getElementById('sidebarTooltip');
        const sidebarNav = document.querySelector('#appSidebar .sidebar-nav');

        function showSidebarTooltip(link) {
            if (!sidebar || !sidebarTooltip || !sidebarNav || !sidebar.classList.contains('sidebar-collapsed') || !window.matchMedia('(min-width: 1024px)').matches) {
                return;
            }

            const label = link.getAttribute('data-sidebar-label');
            if (!label) {
                return;
            }

            const shortcut = link.getAttribute('data-sidebar-shortcut');
            const shortcutHint = `Shift+${shortcut?.toUpperCase()}`;
            sidebarTooltip.textContent = shortcut
                ? `${label} · ${shortcutHint}`
                : label;
            sidebarTooltip.classList.remove('hidden');

            const linkRect = link.getBoundingClientRect();
            const tooltipRect = sidebarTooltip.getBoundingClientRect();
            const left = Math.min(linkRect.right + 12, window.innerWidth - tooltipRect.width - 8);
            const top = Math.max(8, Math.min(linkRect.top + linkRect.height / 2 - tooltipRect.height / 2, window.innerHeight - tooltipRect.height - 8));

            sidebarTooltip.style.left = `${Math.max(8, left)}px`;
            sidebarTooltip.style.top = `${top}px`;
        }

        if (sidebarNav) {
            const sidebarShortcutCodes = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0', 'q', 'w', 'e', 'r', 't'];
            const sidebarLinks = Array.from(sidebarNav.querySelectorAll('a[data-sidebar-label]'));

            sidebarLinks.forEach((link, index) => {
                const shortcut = sidebarShortcutCodes[index];
                if (shortcut) {
                    link.setAttribute('data-sidebar-shortcut', shortcut);
                    const badge = document.createElement('span');
                    badge.className = 'sidebar-shortcut-badge';
                    badge.textContent = `Shift+${shortcut.toUpperCase()}`;
                    badge.setAttribute('aria-hidden', 'true');
                    link.appendChild(badge);
                }

                link.addEventListener('pointerenter', () => showSidebarTooltip(link));
                link.addEventListener('pointerleave', () => sidebarTooltip?.classList.add('hidden'));
                link.addEventListener('focus', () => showSidebarTooltip(link));
                link.addEventListener('blur', () => sidebarTooltip?.classList.add('hidden'));
            });
        }

        function toggleDesktopSidebar(event) {
            const sidebar = document.getElementById('appSidebar');
            const toggle = document.querySelector('.sidebar-collapse-toggle');
            const icon = document.querySelector('.sidebar-toggle-icon');

            if (!sidebar) {
                return;
            }

            if (event) {
                event.preventDefault();
            }

            const isCollapsed = sidebar.classList.toggle('sidebar-collapsed');
            localStorage.setItem('loomflow-sidebar-collapsed', isCollapsed ? 'true' : 'false');
            if (!isCollapsed && sidebarTooltip) {
                sidebarTooltip.classList.add('hidden');
            }

            if (toggle) {
                toggle.setAttribute('aria-expanded', isCollapsed ? 'false' : 'true');
                toggle.setAttribute('aria-label', isCollapsed ? 'Expand sidebar' : 'Collapse sidebar');
                toggle.setAttribute('title', isCollapsed ? 'Expand sidebar · Shift+Y' : 'Collapse sidebar · Shift+Y');
                toggle.setAttribute('data-sidebar-label', isCollapsed ? 'Expand sidebar' : 'Collapse sidebar');
            }

            if (icon) {
                icon.classList.toggle('rotate-180', isCollapsed);
            }
        }

        const sidebarDefaultVersion = 'loomflow-sidebar-default-collapsed-v2';
        if (localStorage.getItem(sidebarDefaultVersion) !== 'true') {
            localStorage.setItem('loomflow-sidebar-collapsed', 'true');
            localStorage.setItem(sidebarDefaultVersion, 'true');
        }

        if (window.matchMedia('(min-width: 1024px)').matches && localStorage.getItem('loomflow-sidebar-collapsed') !== 'false') {
            const sidebar = document.getElementById('appSidebar');
            const toggle = document.querySelector('.sidebar-collapse-toggle');
            const icon = document.querySelector('.sidebar-toggle-icon');

            if (sidebar) {
                sidebar.classList.add('sidebar-collapsed');
            }

            if (toggle) {
                toggle.setAttribute('aria-expanded', 'false');
                toggle.setAttribute('aria-label', 'Expand sidebar');
                toggle.setAttribute('title', 'Expand sidebar · Shift+Y');
                toggle.setAttribute('data-sidebar-label', 'Expand sidebar');
            }
            if (icon) {
                icon.classList.add('rotate-180');
            }
        } else if (window.matchMedia('(min-width: 1024px)').matches) {
            const toggle = document.querySelector('.sidebar-collapse-toggle');
            if (toggle) {
                toggle.setAttribute('aria-expanded', 'true');
                toggle.setAttribute('aria-label', 'Collapse sidebar');
                toggle.setAttribute('title', 'Collapse sidebar · Shift+Y');
                toggle.setAttribute('data-sidebar-label', 'Collapse sidebar');
            }
        }

        let operatorGuidePreviousFocus = null;
        let operatorShiftPresses = [];

        function openOperatorKeyboardGuide() {
            const guide = document.getElementById('operatorKeyboardGuide');
            const dialog = guide?.querySelector('[role="dialog"]');
            if (!guide || !dialog) {
                return;
            }

            operatorGuidePreviousFocus = document.activeElement;
            guide.classList.add('is-open');
            document.body.classList.add('overflow-hidden');
            dialog.focus();
        }

        function closeOperatorKeyboardGuide() {
            const guide = document.getElementById('operatorKeyboardGuide');
            if (!guide) {
                return;
            }

            guide.classList.remove('is-open');
            document.body.classList.remove('overflow-hidden');
            if (operatorGuidePreviousFocus instanceof HTMLElement) {
                operatorGuidePreviousFocus.focus();
            }
        }

        document.addEventListener('change', (event) => {
            const modeSelect = event.target instanceof HTMLSelectElement ? event.target : null;
            const modeForm = modeSelect?.form;
            if (!modeSelect?.matches('.operator-mode-switch select[name="mode"]') || !modeForm) {
                return;
            }

            try {
                sessionStorage.setItem('loomflow-module-mode', modeSelect.value);
            } catch (error) {
                // Keep the current mode switch usable when browser storage is unavailable.
            }

            modeForm.querySelectorAll('[data-mode-preserved-query]').forEach((field) => field.remove());
            new URLSearchParams(window.location.search).forEach((value, key) => {
                if (key === 'mode') {
                    return;
                }

                const field = document.createElement('input');
                field.type = 'hidden';
                field.name = key;
                field.value = value;
                field.dataset.modePreservedQuery = 'true';
                modeForm.appendChild(field);
            });
        }, true);

        const moduleModePathPatterns = [
            /^\/factory\/(?:orders|checking|reports|parchis)\/?$/,
            /^\/(?:bags|sizing|parts|fabric-stock|sales|invoices|accounts|expenses|production)(?:\/.*)?$/,
        ];
        const supportsModuleMode = (pathname) => moduleModePathPatterns.some((pattern) => pattern.test(pathname));
        const currentPageUrl = new URL(window.location.href);
        const currentPageSupportsMode = supportsModuleMode(currentPageUrl.pathname);
        const requestedMode = currentPageUrl.searchParams.get('mode');
        let savedModuleMode = 'operator';

        try {
            savedModuleMode = sessionStorage.getItem('loomflow-module-mode') === 'display' ? 'display' : 'operator';
            if (currentPageSupportsMode && (requestedMode === 'operator' || requestedMode === 'display')) {
                savedModuleMode = requestedMode;
                sessionStorage.setItem('loomflow-module-mode', savedModuleMode);
            } else if (currentPageSupportsMode && requestedMode === null) {
                currentPageUrl.searchParams.set('mode', savedModuleMode);
                window.location.replace(currentPageUrl.href);
            }
        } catch (error) {
            savedModuleMode = requestedMode === 'display' ? 'display' : 'operator';
        }

        document.addEventListener('click', (event) => {
            const anchor = event.target instanceof Element ? event.target.closest('a[href]') : null;
            if (!(anchor instanceof HTMLAnchorElement)) {
                return;
            }

            const destination = new URL(anchor.href, window.location.href);
            if (destination.origin !== window.location.origin || !supportsModuleMode(destination.pathname)) {
                return;
            }

            try {
                savedModuleMode = sessionStorage.getItem('loomflow-module-mode') === 'display' ? 'display' : 'operator';
            } catch (error) {
                // The page's current mode remains the fallback when browser storage is unavailable.
            }

            destination.searchParams.set('mode', savedModuleMode);
            anchor.href = destination.href;
        }, true);

        const operatorShortcutDestinations = {
            '1': @json(route('factory.checking')),
            '2': @json(route('production.index')),
            '3': @json(route('factory.parchis')),
            '4': @json(route('factory.parchis')),
            '5': @json(route('bags.index')),
            '6': @json(route('invoices.payments')),
        };

        document.addEventListener('keydown', (event) => {
            const guide = document.getElementById('operatorKeyboardGuide');
            const guideIsOpen = guide?.classList.contains('is-open');
            const target = event.target instanceof HTMLElement ? event.target : null;
            const isEditingField = target?.matches('input, textarea, select, [contenteditable="true"]') ?? false;

            if (guideIsOpen && event.key === 'Escape') {
                event.preventDefault();
                closeOperatorKeyboardGuide();
                return;
            }

            if (guideIsOpen) {
                if (event.key === 'Tab') {
                    event.preventDefault();
                    guide.querySelector('.operator-guide-close')?.focus();
                }
                return;
            }

            @if(request()->routeIs('sizing.*'))
            if (event.ctrlKey && !event.shiftKey && !event.altKey && !event.metaKey && event.key.toLowerCase() === 'q') {
                const sizingModeSwitch = document.getElementById('sizing-mode-switch');
                if (sizingModeSwitch instanceof HTMLSelectElement) {
                    event.preventDefault();
                    sizingModeSwitch.value = sizingModeSwitch.value === 'display' ? 'operator' : 'display';
                    sizingModeSwitch.form?.requestSubmit();
                }
                return;
            }
            @endif

            @if(request()->routeIs('parts.*'))
            if (event.ctrlKey && !event.shiftKey && !event.altKey && !event.metaKey && event.key.toLowerCase() === 'q') {
                const partsModeSwitch = document.getElementById('parts-mode-switch');
                if (partsModeSwitch instanceof HTMLSelectElement) {
                    event.preventDefault();
                    partsModeSwitch.value = partsModeSwitch.value === 'display' ? 'operator' : 'display';
                    partsModeSwitch.form?.requestSubmit();
                }
                return;
            }
            @endif

            @if(request()->routeIs('fabric.*'))
            if (event.ctrlKey && !event.shiftKey && !event.altKey && !event.metaKey && event.key.toLowerCase() === 'q') {
                const fabricModeSwitch = document.getElementById('fabric-mode-switch');
                if (fabricModeSwitch instanceof HTMLSelectElement) {
                    event.preventDefault();
                    fabricModeSwitch.value = fabricModeSwitch.value === 'display' ? 'operator' : 'display';
                    fabricModeSwitch.form?.requestSubmit();
                }
                return;
            }
            @endif

            @if(request()->routeIs('sales.*'))
            if (event.ctrlKey && !event.shiftKey && !event.altKey && !event.metaKey && event.key.toLowerCase() === 'q') {
                const salesModeSwitch = document.getElementById('sales-mode-switch');
                if (salesModeSwitch instanceof HTMLSelectElement) {
                    event.preventDefault();
                    salesModeSwitch.value = salesModeSwitch.value === 'display' ? 'operator' : 'display';
                    salesModeSwitch.form?.requestSubmit();
                }
                return;
            }
            @endif

            @if(request()->routeIs('invoices.*', 'accounts.*', 'expenses.*'))
            if (event.ctrlKey && !event.shiftKey && !event.altKey && !event.metaKey && event.key.toLowerCase() === 'q') {
                const financeModeSwitch = document.getElementById('finance-mode-switch');
                if (financeModeSwitch instanceof HTMLSelectElement) {
                    event.preventDefault();
                    financeModeSwitch.value = financeModeSwitch.value === 'display' ? 'operator' : 'display';
                    financeModeSwitch.form?.requestSubmit();
                }
                return;
            }
            @endif

            @if(request()->routeIs('factory.orders'))
            if (event.ctrlKey && !event.shiftKey && !event.altKey && !event.metaKey && event.key.toLowerCase() === 'q') {
                const factoryOrdersModeSwitch = document.getElementById('factory-orders-mode-switch');
                if (factoryOrdersModeSwitch instanceof HTMLSelectElement) {
                    event.preventDefault();
                    factoryOrdersModeSwitch.value = factoryOrdersModeSwitch.value === 'display' ? 'operator' : 'display';
                    factoryOrdersModeSwitch.form?.requestSubmit();
                }
                return;
            }
            @endif

            @if(request()->routeIs('production.*'))
            if (event.ctrlKey && !event.shiftKey && !event.altKey && !event.metaKey && event.key.toLowerCase() === 'q') {
                const productionModeSwitch = document.getElementById('production-mode-switch');
                if (productionModeSwitch instanceof HTMLSelectElement) {
                    event.preventDefault();
                    productionModeSwitch.value = productionModeSwitch.value === 'display' ? 'operator' : 'display';
                    productionModeSwitch.form?.requestSubmit();
                }
                return;
            }
            @endif

            @if(request()->routeIs('factory.checking'))
            if (event.ctrlKey && !event.shiftKey && !event.altKey && !event.metaKey && event.key.toLowerCase() === 'q') {
                const factoryCheckingModeSwitch = document.getElementById('factory-checking-mode-switch');
                if (factoryCheckingModeSwitch instanceof HTMLSelectElement) {
                    event.preventDefault();
                    factoryCheckingModeSwitch.value = factoryCheckingModeSwitch.value === 'display' ? 'operator' : 'display';
                    factoryCheckingModeSwitch.form?.requestSubmit();
                }
                return;
            }
            @endif

            @if(request()->routeIs('factory.reports'))
            if (event.ctrlKey && !event.shiftKey && !event.altKey && !event.metaKey && event.key.toLowerCase() === 'q') {
                const factoryReportsModeSwitch = document.getElementById('factory-reports-mode-switch');
                if (factoryReportsModeSwitch instanceof HTMLSelectElement) {
                    event.preventDefault();
                    factoryReportsModeSwitch.value = factoryReportsModeSwitch.value === 'display' ? 'operator' : 'display';
                    factoryReportsModeSwitch.form?.requestSubmit();
                }
                return;
            }
            @endif

            @if(request()->routeIs('bags.index'))
            if (event.ctrlKey && !event.shiftKey && !event.altKey && !event.metaKey && event.key.toLowerCase() === 'q') {
                const bagsModeSwitch = document.getElementById('bags-mode-switch');
                if (bagsModeSwitch instanceof HTMLSelectElement) {
                    event.preventDefault();
                    bagsModeSwitch.value = bagsModeSwitch.value === 'display' ? 'operator' : 'display';
                    bagsModeSwitch.form?.requestSubmit();
                }
                return;
            }
            @endif

            const pressedSidebarShortcut = event.code.replace(/^(Digit|Numpad|Key)/, '').toLowerCase()
                || (event.key === ')' ? '0' : event.key.toLowerCase());
            const isSidebarShortcut = event.shiftKey && !event.ctrlKey && !event.altKey && !event.metaKey;
            if (isSidebarShortcut && pressedSidebarShortcut === 'y' && !isEditingField) {
                event.preventDefault();
                if (window.matchMedia('(min-width: 1024px)').matches) {
                    toggleDesktopSidebar();
                } else {
                    toggleSidebar();
                }
                return;
            }

            if (isSidebarShortcut && !isEditingField) {
                const sidebarShortcutOrder = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0', 'q', 'w', 'e', 'r', 't'];
                const shortcutIndex = sidebarShortcutOrder.indexOf(pressedSidebarShortcut);
                const sidebarLink = sidebarNav?.querySelectorAll('a[data-sidebar-label]')[shortcutIndex];

                if (shortcutIndex >= 0 && sidebarLink instanceof HTMLAnchorElement) {
                    event.preventDefault();
                    sidebarLink.click();
                    return;
                }
            }

            if (event.key === 'Shift' && !event.repeat && !isEditingField && !guideIsOpen) {
                const now = Date.now();
                operatorShiftPresses = operatorShiftPresses.filter((pressedAt) => now - pressedAt < 1200);
                operatorShiftPresses.push(now);
                if (operatorShiftPresses.length >= 3) {
                    operatorShiftPresses = [];
                    openOperatorKeyboardGuide();
                }
                return;
            }

            if (event.altKey && !event.ctrlKey && !event.metaKey && !isEditingField && operatorShortcutDestinations[event.key]) {
                event.preventDefault();
                window.location.assign(operatorShortcutDestinations[event.key]);
                return;
            }

            if (event.key === 'F2' && !event.ctrlKey && !event.metaKey) {
                const firstEditableField = document.querySelector('main input:not([type="hidden"]):not([type="checkbox"]):not([type="radio"]):not([readonly]):not([disabled]), main select:not([disabled]), main textarea:not([readonly]):not([disabled])');
                event.preventDefault();
                if (firstEditableField instanceof HTMLElement) {
                    firstEditableField.focus();
                } else {
                    window.location.assign(@json(route('factory.checking')));
                }
                return;
            }

            if (event.key === 'F8' && !event.ctrlKey && !event.metaKey && isEditingField) {
                const form = target?.closest('main form');
                if (form instanceof HTMLFormElement) {
                    event.preventDefault();
                    const submitter = form.querySelector('button[type="submit"]:not([disabled]), input[type="submit"]:not([disabled])');
                    if (submitter instanceof HTMLElement) {
                        form.requestSubmit(submitter);
                    } else {
                        form.requestSubmit();
                    }
                }
                return;
            }

            if (event.key === 'Enter' && target?.matches('main table input:not([type="hidden"]):not([type="checkbox"]):not([type="radio"]):not([disabled]), main table select:not([disabled])')) {
                const table = target.closest('table');
                const cells = Array.from(table?.querySelectorAll('input:not([type="hidden"]):not([type="checkbox"]):not([type="radio"]):not([disabled]), select:not([disabled])') ?? [])
                    .filter((cell) => cell instanceof HTMLElement && cell.getClientRects().length > 0);
                const currentIndex = cells.indexOf(target);
                const nextIndex = currentIndex + (event.shiftKey ? -1 : 1);
                event.preventDefault();
                if (cells[nextIndex] instanceof HTMLElement) {
                    cells[nextIndex].focus();
                }
                return;
            }

            if (event.key === 'Escape' && !isEditingField && !event.altKey && !event.ctrlKey && !event.metaKey) {
                event.preventDefault();
                window.location.assign(@json(route('dashboard')));
            }
        });

        // Modal Helpers for child views
        function openModal(id) {
            const el = document.getElementById(id);
            if (el) {
                el.classList.remove('hidden');
                if (el.classList.contains('items-center')) {
                    el.classList.add('flex');
                }
                document.body.classList.add('overflow-hidden');
            }
        }

        function closeModal(id) {
            const el = document.getElementById(id);
            if (el) {
                el.classList.add('hidden');
                if (el.classList.contains('items-center')) {
                    el.classList.remove('flex');
                }
                document.body.classList.remove('overflow-hidden');
            }
        }
    </script>
    @stack('scripts')
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('{{ asset('service-worker.js') }}', { scope: '{{ rtrim(asset('/'), '/') }}/' })
                    .catch((error) => console.error('LoomFlow service worker registration failed:', error));
            });
        }
    </script>
</body>
</html>

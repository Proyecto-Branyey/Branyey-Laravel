@props(['show' => true])

@if($show && in_array(request()->route()->getName(), config('whatsapp.enabled_routes', [])))
    <a href="https://wa.me/{{ config('whatsapp.phone_number', '573213229744') }}" 
       target="_blank" 
       rel="noopener noreferrer"
       class="whatsapp-float"
       aria-label="Contactar por WhatsApp">
        <i class="bi bi-whatsapp"></i>
    </a>

    <style>
        .whatsapp-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #25D366;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
            z-index: 1000;
            text-decoration: none;
        }

        .whatsapp-float:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
        }

        .whatsapp-float i {
            font-size: 2rem;
            color: white;
        }

        .whatsapp-float::before {
            content: "WhatsApp";
            position: absolute;
            right: 70px;
            background: rgba(0,0,0,0.8);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .whatsapp-float:hover::before {
            opacity: 1;
            visibility: visible;
            transform: translateX(-5px);
        }

        @media (max-width: 768px) {
            .whatsapp-float {
                width: 50px;
                height: 50px;
                bottom: 20px;
                right: 20px;
            }
            .whatsapp-float i {
                font-size: 1.5rem;
            }
            .whatsapp-float::before {
                display: none;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const whatsappBtn = document.querySelector('.whatsapp-float');
            if (whatsappBtn) {
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 300) {
                        whatsappBtn.style.opacity = '1';
                        whatsappBtn.style.visibility = 'visible';
                    } else {
                        whatsappBtn.style.opacity = '0.7';
                        whatsappBtn.style.visibility = 'visible';
                    }
                });
            }
        });
    </script>
@endif
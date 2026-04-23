/**
 * Accessibility Module for Risk Management System
 * Features: Text-to-Speech, High Contrast, Font Scaling, Dyslexic Font
 */

class AccessibilityModule {
    constructor() {
        console.log('Accessibility Module Initializing...');
        this.fontSize = parseInt(localStorage.getItem('acc-font-size')) || 100;
        this.highContrast = localStorage.getItem('acc-contrast') === 'true';
        this.dyslexicFont = localStorage.getItem('acc-dyslexic') === 'true';
        this.isSpeaking = false;
        this.synth = window.speechSynthesis;
        this.currentLang = document.documentElement.lang || 'id';
        
        this.init();
    }

    init() {
        this.injectStyles();
        this.renderWidget();
        this.applySettings();
        this.bindEvents();
    }

    injectStyles() {
        const styles = `
            /* Accessibility Widget */
            .acc-widget { position: fixed !important; bottom: 30px !important; right: 30px !important; z-index: 999999 !important; }
            .acc-btn { 
                width: 60px; height: 60px; border-radius: 50%; background: #047857; color: white; 
                border: 3px solid #fff; box-shadow: 0 4px 20px rgba(0,0,0,0.4); cursor: pointer; font-size: 1.8rem;
                display: flex; align-items: center; justify-content: center; transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                animation: pulse-green 2s infinite;
            }
            @keyframes pulse-green {
                0% { box-shadow: 0 0 0 0 rgba(4, 120, 87, 0.7); }
                70% { box-shadow: 0 0 0 15px rgba(4, 120, 87, 0); }
                100% { box-shadow: 0 0 0 0 rgba(4, 120, 87, 0); }
            }
            .acc-btn:hover { transform: scale(1.1); background: #065f46; }
            .acc-menu { 
                position: absolute; bottom: 65px; right: 0; width: 280px; background: white; 
                border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); padding: 20px; 
                display: none; border: 1px solid #e5e7eb;
            }
            .acc-menu.show { display: block; animation: slideUp 0.3s ease; }
            @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
            
            .acc-title { font-weight: 800; font-size: 1rem; color: #111827; margin-bottom: 15px; border-bottom: 1px solid #f3f4f6; padding-bottom: 10px; }
            .acc-item { margin-bottom: 15px; }
            .acc-label { font-size: 0.8rem; font-weight: 600; color: #6b7280; display: block; margin-bottom: 8px; }
            .acc-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; }
            .acc-opt { 
                padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px; cursor: pointer; text-align: center;
                font-size: 0.75rem; font-weight: 600; transition: all 0.2s; background: #f9fafb;
            }
            .acc-opt:hover { background: #f0fdf4; border-color: #059669; }
            .acc-opt.active { background: #047857; color: white; border-color: #047857; }
            
            /* Accessibility Global Classes */
            .acc-contrast-mode { filter: contrast(1.5) !important; background-color: #000 !important; color: #fff !important; }
            .acc-contrast-mode * { border-color: #555 !important; }
            .acc-dyslexic-mode { font-family: 'OpenDyslexic', sans-serif !important; }
            
            @font-face {
                font-family: 'OpenDyslexic';
                src: url('https://cdn.jsdelivr.net/npm/opendyslexic@1.0.3/OpenDyslexic-Regular.otf');
            }
        `;
        const styleSheet = document.createElement("style");
        styleSheet.innerText = styles;
        document.head.appendChild(styleSheet);
    }

    renderWidget() {
        const widget = document.createElement('div');
        widget.className = 'acc-widget d-print-none';
        widget.innerHTML = `
            <div class="acc-menu" id="accMenu">
                <div class="acc-title"><i class="fas fa-universal-access mr-2"></i> Aksesibilitas</div>
                
                <div class="acc-item">
                    <span class="acc-label">Kontrol Suara (TTS)</span>
                    <div class="acc-grid">
                        <div class="acc-opt" id="btnSpeak"><i class="fas fa-volume-up mr-2"></i> Baca Teks</div>
                        <div class="acc-opt" id="btnStop"><i class="fas fa-stop mr-2"></i> Berhenti</div>
                    </div>
                </div>

                <div class="acc-item">
                    <span class="acc-label">Ukuran Font</span>
                    <div class="acc-grid">
                        <div class="acc-opt" onclick="acc.changeFontSize(-10)"><i class="fas fa-minus mr-2"></i> Kecil</div>
                        <div class="acc-opt" onclick="acc.changeFontSize(10)"><i class="fas fa-plus mr-2"></i> Besar</div>
                    </div>
                </div>

                <div class="acc-item">
                    <span class="acc-label">Visual</span>
                    <div class="acc-grid">
                        <div class="acc-opt" id="btnContrast"><i class="fas fa-adjust mr-2"></i> Kontras</div>
                        <div class="acc-opt" id="btnDyslexic"><i class="fas fa-font mr-2"></i> Ramah Disleksia</div>
                    </div>
                </div>
                
                <div class="text-center mt-2">
                    <small class="text-muted" style="font-size: 0.6rem;">Bahasa Terdeteksi: <strong>${this.currentLang.toUpperCase()}</strong></small>
                </div>
            </div>
            <button class="acc-btn" id="accMainBtn" title="Menu Aksesibilitas">
                <i class="fas fa-universal-access"></i>
            </button>
        `;
        document.body.appendChild(widget);
    }

    bindEvents() {
        document.getElementById('accMainBtn').addEventListener('click', () => {
            document.getElementById('accMenu').classList.toggle('show');
        });

        document.getElementById('btnContrast').addEventListener('click', () => this.toggleContrast());
        document.getElementById('btnDyslexic').addEventListener('click', () => this.toggleDyslexic());
        document.getElementById('btnSpeak').addEventListener('click', () => this.speakContent());
        document.getElementById('btnStop').addEventListener('click', () => this.stopSpeaking());

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.acc-widget')) {
                document.getElementById('accMenu').classList.remove('show');
            }
        });
    }

    applySettings() {
        document.body.style.fontSize = this.fontSize + '%';
        if (this.highContrast) document.body.classList.add('acc-contrast-mode');
        if (this.dyslexicFont) document.body.classList.add('acc-dyslexic-mode');
        
        this.updateButtons();
    }

    updateButtons() {
        document.getElementById('btnContrast').classList.toggle('active', this.highContrast);
        document.getElementById('btnDyslexic').classList.toggle('active', this.dyslexicFont);
    }

    changeFontSize(delta) {
        this.fontSize = Math.min(Math.max(this.fontSize + delta, 80), 150);
        document.body.style.fontSize = this.fontSize + '%';
        localStorage.setItem('acc-font-size', this.fontSize);
    }

    toggleContrast() {
        this.highContrast = !this.highContrast;
        document.body.classList.toggle('acc-contrast-mode', this.highContrast);
        localStorage.setItem('acc-contrast', this.highContrast);
        this.updateButtons();
    }

    toggleDyslexic() {
        this.dyslexicFont = !this.dyslexicFont;
        document.body.classList.toggle('acc-dyslexic-mode', this.dyslexicFont);
        localStorage.setItem('acc-dyslexic', this.dyslexicFont);
        this.updateButtons();
    }

    /**
     * TEXT TO SPEECH LOGIC
     */
    speakContent() {
        if (this.isSpeaking) return;
        
        // Get content to read (prioritize main content)
        const content = document.querySelector('.content-wrapper') || document.body;
        const textToRead = content.innerText
            .replace(/[\n\t]+/g, ' ')
            .substring(0, 5000); // Limit to 5000 chars

        const utterance = new SpeechSynthesisUtterance(textToRead);
        
        // Set voice based on language
        const voices = this.synth.getVoices();
        const langMap = {
            'id': ['id-ID', 'id_ID'],
            'en': ['en-US', 'en-GB'],
            'ar': ['ar-SA', 'ar_SA']
        };

        const targetLangs = langMap[this.currentLang] || ['id-ID'];
        const voice = voices.find(v => targetLangs.some(l => v.lang.includes(l)));

        if (voice) {
            utterance.voice = voice;
        }
        
        utterance.lang = targetLangs[0];
        utterance.rate = 0.9; // Slightly slower for clarity
        utterance.pitch = 1;

        utterance.onstart = () => {
            this.isSpeaking = true;
            document.getElementById('btnSpeak').classList.add('active');
        };

        utterance.onend = () => {
            this.isSpeaking = false;
            document.getElementById('btnSpeak').classList.remove('active');
        };

        this.synth.speak(utterance);
    }

    stopSpeaking() {
        this.synth.cancel();
        this.isSpeaking = false;
        document.getElementById('btnSpeak').classList.remove('active');
    }
}

// Initialize
window.addEventListener('DOMContentLoaded', () => {
    window.acc = new AccessibilityModule();
});

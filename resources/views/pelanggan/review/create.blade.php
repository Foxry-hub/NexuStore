@extends('layouts.app')

@section('title', 'Beri Ulasan - NEXUSTORE')

@section('content')
<section class="review-section">
    <div class="container">
        <div class="review-card">
            <div class="review-header">
                <h1><i class="fas fa-star"></i> Beri Ulasan</h1>
                <p>Bagikan pengalaman Anda dengan buku ini</p>
            </div>

            <div class="book-info-review">
                <img src="{{ $buku->gambar_cover ? asset('storage/' . $buku->gambar_cover) : 'https://via.placeholder.com/120x160/5B4AB3/ffffff?text=' . urlencode($buku->judul) }}" alt="{{ $buku->judul }}" class="book-cover">
                <div class="book-details">
                    <h3>{{ $buku->judul }}</h3>
                    <p class="author">oleh {{ $buku->penulis }}</p>
                    <p class="order-info">
                        <i class="fas fa-receipt"></i> 
                        Pesanan: <strong>NXS-{{ str_pad($pesanan->id_pesanan, 6, '0', STR_PAD_LEFT) }}</strong>
                    </p>
                </div>
            </div>

            <form action="{{ route('review.store') }}" method="POST" class="review-form">
                @csrf
                <input type="hidden" name="id_buku" value="{{ $buku->id_buku }}">
                <input type="hidden" name="id_pesanan" value="{{ $pesanan->id_pesanan }}">

                <div class="form-group">
                    <label>Rating</label>
                    <div class="star-rating">
                        @for($i = 5; $i >= 1; $i--)
                        <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" required>
                        <label for="star{{ $i }}" title="{{ $i }} bintang">
                            <i class="fas fa-star"></i>
                        </label>
                        @endfor
                    </div>
                    <div class="rating-text-display">Pilih rating</div>
                    @error('rating')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="ulasan">Ulasan Anda</label>
                    <textarea name="ulasan" id="ulasan" rows="5" placeholder="Ceritakan pengalaman Anda dengan buku ini... (opsional)">{{ old('ulasan') }}</textarea>
                    <span class="char-count"><span id="charCount">0</span>/1000</span>
                    @error('ulasan')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('pesanan.show', $pesanan->id_pesanan) }}" class="btn-cancel">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i> Kirim Ulasan
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@push('styles')
<style>
.review-section {
    padding: 60px 0;
    background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ec 100%);
    min-height: calc(100vh - 80px);
}

.review-card {
    max-width: 600px;
    margin: 0 auto;
    background: white;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    overflow: hidden;
}

.review-header {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    padding: 30px;
    text-align: center;
    color: white;
}

.review-header h1 {
    font-size: 24px;
    margin-bottom: 8px;
}

.review-header h1 i {
    margin-right: 10px;
}

.review-header p {
    opacity: 0.9;
    font-size: 14px;
}

.book-info-review {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 25px 30px;
    background: #fff;
    border-bottom: 1px solid #eee;
}

.book-info-review .book-cover {
    width: 70px;
    height: 100px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    flex-shrink: 0;
}

.book-info-review .book-details h3 {
    font-size: 16px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 5px;
}

.book-info-review .author {
    font-size: 14px;
    color: #666;
    margin-bottom: 10px;
}

.book-info-review .order-info {
    font-size: 13px;
    color: #888;
}

.book-info-review .order-info i {
    color: var(--primary-color);
}

.review-form {
    padding: 30px;
}

.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 10px;
    color: var(--text-dark);
}

/* Star Rating */
.star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    gap: 5px;
}

.star-rating input {
    display: none;
}

.star-rating label {
    cursor: pointer;
    font-size: 32px;
    color: #ddd;
    transition: all 0.2s;
}

.star-rating label:hover,
.star-rating label:hover ~ label,
.star-rating input:checked ~ label {
    color: #FFA500;
    transform: scale(1.1);
}

.rating-text-display {
    margin-top: 10px;
    font-size: 14px;
    color: #888;
    font-style: italic;
}

.form-group textarea {
    width: 100%;
    padding: 15px;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    font-size: 14px;
    font-family: inherit;
    resize: vertical;
    min-height: 120px;
    transition: border-color 0.3s;
}

.form-group textarea:focus {
    outline: none;
    border-color: var(--primary-color);
}

.form-group textarea::placeholder {
    color: #aaa;
}

.char-count {
    display: block;
    text-align: right;
    font-size: 12px;
    color: #888;
    margin-top: 5px;
}

.error-text {
    display: block;
    color: #dc3545;
    font-size: 13px;
    margin-top: 5px;
}

.form-actions {
    display: flex;
    gap: 15px;
    justify-content: space-between;
    margin-top: 30px;
}

.btn-cancel {
    flex: 1;
    padding: 14px 20px;
    background: #f5f5f5;
    color: #666;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 600;
    text-align: center;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-cancel:hover {
    background: #eee;
}

.btn-submit {
    flex: 1;
    padding: 14px 20px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(91, 74, 179, 0.4);
}

@media (max-width: 576px) {
    .review-card {
        margin: 0 15px;
    }
    
    .book-info-review {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    
    .star-rating label {
        font-size: 28px;
    }
    
    .form-actions {
        flex-direction: column;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Character count
    const textarea = document.getElementById('ulasan');
    const charCount = document.getElementById('charCount');
    
    textarea.addEventListener('input', function() {
        charCount.textContent = this.value.length;
        if (this.value.length > 1000) {
            charCount.style.color = '#dc3545';
        } else {
            charCount.style.color = '#888';
        }
    });
    
    // Rating text display
    const ratingTexts = {
        1: '😞 Sangat Buruk',
        2: '😐 Buruk',
        3: '🙂 Cukup',
        4: '😊 Bagus',
        5: '🤩 Sangat Bagus!'
    };
    
    const ratingDisplay = document.querySelector('.rating-text-display');
    const starInputs = document.querySelectorAll('.star-rating input');
    
    starInputs.forEach(input => {
        input.addEventListener('change', function() {
            ratingDisplay.textContent = ratingTexts[this.value];
            ratingDisplay.style.color = '#333';
            ratingDisplay.style.fontStyle = 'normal';
        });
    });
});
</script>
@endpush
@endsection

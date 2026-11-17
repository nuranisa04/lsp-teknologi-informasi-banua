@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('breadcrumb', 'Profil Pengguna')

@section('content')
    @php
        $profileFields = ['nama', 'email', 'no_whatsapp', 'profile_photo'];
        $passwordFields = ['current_password', 'password_baru'];
        $hasProfileErrors = $errors->hasAny($profileFields);
        $hasPasswordErrors = $errors->hasAny($passwordFields);
        $photoUrl = $user->foto_profile
            ? asset('storage/' . $user->foto_profile)
            : null;
    @endphp

    <div class="profile-page">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
            <div>
                <h2 class="page-title mb-1">Profil Pengguna</h2>
            </div>
        </div>

        <div
            id="profileViewPanel"
            class="card profile-card mb-4"
            @if ($hasProfileErrors) hidden @endif
        >
            <div class="card-body p-4 p-lg-5">
                <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start gap-4">
                    <div class="profile-avatar-wrap">
                        <img
                            id="profileAvatarPhoto"
                            src="{{ $photoUrl ?? '' }}"
                            alt="Foto profil {{ $user->nama }}"
                            class="profile-avatar profile-avatar-photo"
                            @if (!$photoUrl) hidden @endif
                        >
                        <div
                            id="profileAvatarFallback"
                            class="profile-avatar"
                            aria-hidden="true"
                            @if ($photoUrl) hidden @endif
                        >
                            <i class="bi bi-person-fill"></i>
                        </div>
                    </div>

                    <div class="flex-grow-1 w-100">
                        <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start justify-content-between gap-3">
                            <div class="text-center text-md-start">
                                <h3 class="h4 fw-bold mb-2">{{ $user->nama }}</h3>
                                <div class="d-flex flex-wrap justify-content-center justify-content-md-start align-items-center gap-2">
                                    <span class="badge rounded-pill text-bg-warning px-3 py-2">
                                        {{ $user->role?->nama_role ?? '-' }}
                                    </span>
                                </div>
                            </div>

                            @if ($user->isAdmin())
                                <div class="d-flex flex-wrap justify-content-center gap-2">
                                    <button
                                        type="button"
                                        class="btn btn-lsp btn-save"
                                        data-show-panel="profileEditPanel"
                                        aria-controls="profileEditPanel"
                                        aria-expanded="false"
                                    >
                                        <i class="bi bi-pencil-square me-1" aria-hidden="true"></i>
                                        Edit Profil
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-back"
                                        data-show-panel="passwordPanel"
                                        aria-controls="passwordPanel"
                                        aria-expanded="false"
                                    >
                                        <i class="bi bi-key me-1" aria-hidden="true"></i>
                                        Ubah Password
                                    </button>
                                </div>
                            @endif
                        </div>

                        <dl class="profile-details mt-4 mb-0">
                            <div class="profile-detail-item">
                                <dt>Email</dt>
                                <dd>{{ $user->email }}</dd>
                            </div>
                            <div class="profile-detail-item">
                                <dt>Nomor WhatsApp</dt>
                                <dd>{{ $user->no_whatsapp ?: '-' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div
            id="profileEditPanel"
            class="card mb-4"
            @if (!$hasProfileErrors) hidden @endif
        >
            <div class="card-header bg-white py-3">
                <h3 class="h5 fw-bold mb-0">Edit Profil</h3>
            </div>
            <div class="card-body p-4">
                <form
                    id="profileEditForm"
                    action="{{ route('profile.update') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    data-original-photo="{{ $photoUrl ?? '' }}"
                >
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nama" class="form-label fw-semibold">Nama Lengkap</label>
                            <input
                                id="nama"
                                type="text"
                                name="nama"
                                class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $user->nama) }}"
                                maxlength="255"
                                required
                                autocomplete="name"
                            >
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}"
                                maxlength="255"
                                required
                                autocomplete="email"
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="no_whatsapp" class="form-label fw-semibold">Nomor WhatsApp</label>
                            <input
                                id="no_whatsapp"
                                type="tel"
                                name="no_whatsapp"
                                class="form-control @error('no_whatsapp') is-invalid @enderror"
                                value="{{ old('no_whatsapp', $user->no_whatsapp) }}"
                                maxlength="30"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                autocomplete="tel"
                            >
                            @error('no_whatsapp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="profile_photo" class="form-label fw-semibold">Foto Profil</label>
                            <input
                                id="profile_photo"
                                type="file"
                                name="profile_photo"
                                class="form-control @error('profile_photo') is-invalid @enderror"
                                accept="image/jpeg,image/png,image/webp"
                            >
                            <div class="form-text">Format JPG, PNG, atau WebP. Maksimal 2 MB. Foto dapat dipotong sebelum disimpan.</div>
                            <div id="profilePhotoClientError" class="invalid-feedback d-block" hidden></div>
                            @error('profile_photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex flex-wrap justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-back" data-cancel-edit>
                            Batal
                        </button>
                        <button type="submit" class="btn btn-lsp btn-save">
                            <i class="bi bi-check2-circle me-1" aria-hidden="true"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div
            id="passwordPanel"
            class="card"
            @if (!$hasPasswordErrors) hidden @endif
        >
            <div class="card-header bg-white py-3">
                <h3 class="h5 fw-bold mb-0">Ubah Password</h3>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('profile.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-12">
                            <label for="current_password" class="form-label fw-semibold">Password Saat Ini</label>
                            <input
                                id="current_password"
                                type="password"
                                name="current_password"
                                class="form-control @error('current_password') is-invalid @enderror"
                                required
                                autocomplete="current-password"
                            >
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password_baru" class="form-label fw-semibold">Password Baru</label>
                            <input
                                id="password_baru"
                                type="password"
                                name="password_baru"
                                class="form-control @error('password_baru') is-invalid @enderror"
                                minlength="8"
                                required
                                autocomplete="new-password"
                            >
                            @error('password_baru')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Minimal 8 karakter.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="password_baru_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru</label>
                            <input
                                id="password_baru_confirmation"
                                type="password"
                                name="password_baru_confirmation"
                                class="form-control"
                                minlength="8"
                                required
                                autocomplete="new-password"
                            >
                        </div>
                    </div>

                    <div class="d-flex flex-wrap justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-back" data-cancel-password>
                            Batal
                        </button>
                        <button type="submit" class="btn btn-lsp btn-save">
                            <i class="bi bi-key me-1" aria-hidden="true"></i>
                            Simpan Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div
        class="modal fade"
        id="profilePhotoCropModal"
        tabindex="-1"
        aria-labelledby="profilePhotoCropModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h2 class="modal-title fs-5 fw-bold" id="profilePhotoCropModalLabel">
                        Sesuaikan Foto Profil
                    </h2>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Tutup"
                    ></button>
                </div>
                <div class="modal-body d-flex flex-column align-items-center gap-3">
                    <p class="text-muted small text-center mb-0">
                        Geser foto untuk mengatur posisi, lalu gunakan pengatur zoom.
                    </p>
                    <div id="profileCropViewport" class="profile-crop-viewport" aria-label="Area pemotongan foto">
                        <img id="profileCropImage" class="profile-crop-image" alt="Pratinjau foto yang akan dipotong">
                    </div>
                    <div class="w-100">
                        <label for="profileCropZoom" class="form-label fw-semibold">Perbesar foto</label>
                        <input
                            id="profileCropZoom"
                            type="range"
                            class="form-range"
                            min="1"
                            max="3"
                            step="0.01"
                            value="1"
                        >
                    </div>
                    <div id="profileCropError" class="alert alert-danger w-100 mb-0" role="alert" hidden></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-back" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="button" id="profileCropApply" class="btn btn-lsp btn-save">
                        <i class="bi bi-crop me-1" aria-hidden="true"></i>
                        Gunakan Foto
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .profile-card {
            border: 1px solid #eee8d5;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(34, 34, 34, .05);
        }

        .profile-avatar-wrap {
            flex: 0 0 auto;
        }

        .profile-avatar {
            width: 112px;
            height: 112px;
            display: grid;
            place-items: center;
            border: 1px solid #f0dc72;
            border-radius: 50%;
            background: linear-gradient(145deg, #fff8d5, #f4cd00);
            color: #222;
            font-size: 48px;
        }

        .profile-avatar-photo {
            object-fit: cover;
        }

        .profile-crop-viewport {
            position: relative;
            width: min(320px, 78vw);
            aspect-ratio: 1;
            overflow: hidden;
            border: 2px solid #f4cd00;
            border-radius: 16px;
            background-color: #202020;
            cursor: grab;
            touch-action: none;
        }

        .profile-crop-viewport:active {
            cursor: grabbing;
        }

        .profile-crop-image {
            position: absolute;
            max-width: none;
            user-select: none;
            pointer-events: none;
        }

        .profile-detail-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 14px 16px 14px 0;
            border-bottom: 1px solid #eee;
        }

        .profile-detail-item:last-child {
            border-bottom: 0;
        }

        .profile-details dt {
            margin-bottom: 0;
            color: #737373;
            font-size: .9rem;
            font-weight: 500;
        }

        .profile-details dd {
            margin: 0;
            color: #222;
            font-weight: 600;
            text-align: right;
            overflow-wrap: anywhere;
        }

        @media (max-width: 575.98px) {
            .profile-detail-item {
                align-items: flex-start;
                flex-direction: column;
                gap: 4px;
                padding-right: 0;
            }

            .profile-details dd {
                text-align: left;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        (() => {
            const profileView = document.getElementById('profileViewPanel');
            const profileEdit = document.getElementById('profileEditPanel');
            const passwordPanel = document.getElementById('passwordPanel');
            const profileForm = document.getElementById('profileEditForm');
            const photoInput = document.getElementById('profile_photo');
            const photoClientError = document.getElementById('profilePhotoClientError');
            const profilePhoto = document.getElementById('profileAvatarPhoto');
            const profileFallback = document.getElementById('profileAvatarFallback');
            const topbarPhoto = document.getElementById('topbarProfilePhoto');
            const topbarFallback = document.getElementById('topbarProfileFallback');
            const cropModalElement = document.getElementById('profilePhotoCropModal');
            const cropModal = cropModalElement
                ? bootstrap.Modal.getOrCreateInstance(cropModalElement)
                : null;
            const cropViewport = document.getElementById('profileCropViewport');
            const cropImage = document.getElementById('profileCropImage');
            const cropZoom = document.getElementById('profileCropZoom');
            const cropError = document.getElementById('profileCropError');
            const cropApply = document.getElementById('profileCropApply');
            const maximumPhotoSize = 2 * 1024 * 1024;
            const cropOutputSize = 512;
            let previewUrl = null;
            let cropSourceUrl = null;
            let cropSourceFile = null;
            let cropScale = 1;
            let cropMinimumScale = 1;
            let cropLeft = 0;
            let cropTop = 0;
            let dragPointer = null;

            const releasePreview = () => {
                if (previewUrl) {
                    URL.revokeObjectURL(previewUrl);
                    previewUrl = null;
                }
            };

            const showPhoto = (url) => {
                [profilePhoto, topbarPhoto].forEach((image) => {
                    if (!image) {
                        return;
                    }

                    image.src = url || '';
                    image.hidden = !url;
                });

                if (profileFallback) {
                    profileFallback.hidden = Boolean(url);
                }

                if (topbarFallback) {
                    topbarFallback.hidden = Boolean(url);
                }
            };

            const showCropError = (message) => {
                cropError.textContent = message;
                cropError.hidden = false;
            };

            const showInputError = (message) => {
                photoClientError.textContent = message;
                photoClientError.hidden = false;
            };

            const constrainCropPosition = () => {
                const viewportSize = cropViewport.clientWidth;
                const imageWidth = cropImage.naturalWidth * cropScale;
                const imageHeight = cropImage.naturalHeight * cropScale;

                cropLeft = Math.min(0, Math.max(viewportSize - imageWidth, cropLeft));
                cropTop = Math.min(0, Math.max(viewportSize - imageHeight, cropTop));
            };

            const renderCropImage = () => {
                cropImage.style.width = `${cropImage.naturalWidth * cropScale}px`;
                cropImage.style.height = `${cropImage.naturalHeight * cropScale}px`;
                cropImage.style.left = `${cropLeft}px`;
                cropImage.style.top = `${cropTop}px`;
            };

            const resetCropImage = () => {
                const viewportSize = cropViewport.clientWidth;
                cropMinimumScale = Math.max(
                    viewportSize / cropImage.naturalWidth,
                    viewportSize / cropImage.naturalHeight
                );
                cropScale = cropMinimumScale;
                cropLeft = (viewportSize - cropImage.naturalWidth * cropScale) / 2;
                cropTop = (viewportSize - cropImage.naturalHeight * cropScale) / 2;
                cropZoom.value = '1';
                renderCropImage();
            };

            const releaseCropSource = () => {
                if (cropSourceUrl) {
                    URL.revokeObjectURL(cropSourceUrl);
                    cropSourceUrl = null;
                }
                cropSourceFile = null;
            };

            document.querySelectorAll('[data-show-panel]').forEach((button) => {
                button.addEventListener('click', () => {
                    const panel = document.getElementById(button.dataset.showPanel);
                    const isProfileEdit = panel === profileEdit;

                    releasePreview();
                    if (isProfileEdit) {
                        profileForm.reset();
                    }

                    if (profileView) {
                        profileView.hidden = isProfileEdit;
                    }
                    profileEdit.hidden = !isProfileEdit;
                    passwordPanel.hidden = isProfileEdit;
                    panel.hidden = false;
                    button.setAttribute('aria-expanded', 'true');
                });
            });

            document.querySelectorAll('[data-cancel-edit]').forEach((button) => {
                button.addEventListener('click', () => {
                    profileForm.reset();
                    releasePreview();
                    showPhoto(profileForm.dataset.originalPhoto);
                    profileEdit.hidden = true;
                    profileView.hidden = false;
                });
            });

            document.querySelectorAll('[data-cancel-password]').forEach((button) => {
                button.addEventListener('click', () => {
                    button.closest('.card').querySelector('form').reset();
                    passwordPanel.hidden = true;
                    profileView.hidden = false;
                });
            });

            photoInput?.addEventListener('change', () => {
                const file = photoInput.files?.[0];
                if (!file) {
                    return;
                }

                photoClientError.hidden = true;
                if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
                    photoInput.value = '';
                    showInputError('Pilih foto dengan format JPG, PNG, atau WebP.');
                    return;
                }

                if (file.size > maximumPhotoSize) {
                    photoInput.value = '';
                    showInputError('Ukuran foto maksimal 2 MB.');
                    return;
                }

                cropError.hidden = true;
                releaseCropSource();
                cropSourceFile = file;
                cropSourceUrl = URL.createObjectURL(file);
                cropImage.onload = () => {
                    cropModal.show();
                };
                cropImage.onerror = () => {
                    showInputError('Foto tidak dapat dibuka. Silakan pilih file gambar lain.');
                    releaseCropSource();
                    photoInput.value = '';
                };
                cropImage.src = cropSourceUrl;
            });

            cropModalElement?.addEventListener('shown.bs.modal', resetCropImage);

            cropZoom?.addEventListener('input', () => {
                const viewportSize = cropViewport.clientWidth;
                const imageCenterX = cropLeft + cropImage.naturalWidth * cropScale / 2;
                const imageCenterY = cropTop + cropImage.naturalHeight * cropScale / 2;
                cropScale = cropMinimumScale * Number(cropZoom.value);
                cropLeft = imageCenterX - cropImage.naturalWidth * cropScale / 2;
                cropTop = imageCenterY - cropImage.naturalHeight * cropScale / 2;
                constrainCropPosition();
                renderCropImage();
            });

            cropViewport?.addEventListener('pointerdown', (event) => {
                dragPointer = { x: event.clientX, y: event.clientY };
                cropViewport.setPointerCapture(event.pointerId);
            });

            cropViewport?.addEventListener('pointermove', (event) => {
                if (!dragPointer) {
                    return;
                }

                cropLeft += event.clientX - dragPointer.x;
                cropTop += event.clientY - dragPointer.y;
                dragPointer = { x: event.clientX, y: event.clientY };
                constrainCropPosition();
                renderCropImage();
            });

            cropViewport?.addEventListener('pointerup', () => {
                dragPointer = null;
            });

            cropViewport?.addEventListener('pointercancel', () => {
                dragPointer = null;
            });

            cropApply?.addEventListener('click', () => {
                if (!cropSourceFile || !cropImage.naturalWidth) {
                    showCropError('Pilih foto terlebih dahulu sebelum melanjutkan.');
                    return;
                }

                const viewportSize = cropViewport.clientWidth;
                const sourceX = Math.max(0, -cropLeft / cropScale);
                const sourceY = Math.max(0, -cropTop / cropScale);
                const sourceSize = viewportSize / cropScale;
                const canvas = document.createElement('canvas');
                canvas.width = cropOutputSize;
                canvas.height = cropOutputSize;
                const context = canvas.getContext('2d');

                if (!context) {
                    showCropError('Pemotongan foto tidak dapat dilakukan di browser ini.');
                    return;
                }

                context.drawImage(
                    cropImage,
                    sourceX,
                    sourceY,
                    sourceSize,
                    sourceSize,
                    0,
                    0,
                    cropOutputSize,
                    cropOutputSize
                );

                canvas.toBlob((blob) => {
                    if (!blob) {
                        showCropError('Hasil foto gagal diproses. Silakan coba kembali.');
                        return;
                    }

                    const croppedFile = new File(
                        [blob],
                        'foto-profil.jpg',
                        { type: 'image/jpeg', lastModified: Date.now() }
                    );
                    const transfer = new DataTransfer();
                    transfer.items.add(croppedFile);
                    photoInput.files = transfer.files;

                    releasePreview();
                    previewUrl = URL.createObjectURL(croppedFile);
                    showPhoto(previewUrl);
                    cropModal.hide();
                    releaseCropSource();
                }, 'image/jpeg', 0.9);
            });

            cropModalElement?.addEventListener('hidden.bs.modal', () => {
                if (cropSourceFile) {
                    photoInput.value = '';
                    releaseCropSource();
                }
                dragPointer = null;
            });
        })();
    </script>
@endpush

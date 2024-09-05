export class OverlayError extends Error {
  constructor(message) {
    super(message);
    this.name = 'OverlayErrors';
  }

  displayError() {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: this.message,
    });
  }
}

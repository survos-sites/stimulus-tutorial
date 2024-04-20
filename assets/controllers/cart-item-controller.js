import { useStimulusReactive } from "stimulus-reactive";
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
  static targets = ["total"];
  static values = {
    price: Number,
    quantity: { type: Number, default: 1 },
  };

  static afterLoad(identifier, application) {
    useStimulusReactive(identifier, application);
  }

  get total() {
    return this.priceValue * this.quantityValue;
  }

  connect() {
    this.effect(() => (this.totalTarget.textContent = this.total));
  }

  changeQuantity(e) {
    this.quantityValue = parseInt(e.target.value);
  }

  remove() {
    this.element.remove();
  }
}

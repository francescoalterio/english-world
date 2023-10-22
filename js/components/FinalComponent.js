import { $, element } from "../tools.js";

export function FinalComponent({ $container }) {
  const $buttonEnd = element("button");
  $buttonEnd.textContent = "End";

  $container.append($buttonEnd);
}

import { $, element } from "../tools.js";

export function InitialComponent({ $container }) {
  const $buttonStart = element("button");
  $buttonStart.textContent = "Start";

  $container.append($buttonStart);
}

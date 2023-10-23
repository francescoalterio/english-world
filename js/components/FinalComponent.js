import { $, element } from "../tools.js";
import { Indexs } from "./Indexs.js";

export function FinalComponent({ $container, wordsState }) {
  const $title = element("p");
  const $buttonEnd = element("button");
  $buttonEnd.textContent = "Continue";

  $title.classList.add("title");

  $title.textContent = "Final Score";

  $buttonEnd.classList.add("primary-button");
  $buttonEnd.setAttribute("type", "submit");

  const $indexsContainer = Indexs({ wordsState });

  $container.append($title, $indexsContainer, $buttonEnd);
}
